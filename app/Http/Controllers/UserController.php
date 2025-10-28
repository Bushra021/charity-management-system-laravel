<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function reg_form()
    {
        return view('user.reg_form', ['areas' => Area::all()]);
    }

    public function register(Request $request)
    {
        // أولاً: تحقق بسيط من أنه أحد الحقلين موجود
        if (!$request->username && !$request->id_number) {
            return back()->withErrors([
                'id_number' => 'يجب إدخال البريد الإلكتروني أو رقم الهوية',
            ])->withInput();
        }

        // التحقق من القيم بناءً على المدخلات
        $rules = [
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'gender' => 'required|in:ذكر,أنثى',
            'area_id' => 'required|exists:areas,id',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ];

        // فقط تحقق من الإيميل إذا المستخدم أدخله
        if ($request->filled('username')) {
            $rules['username'] = 'email|max:255|unique:users,username';
        }

        // فقط تحقق من رقم الهوية إذا المستخدم أدخله
        if ($request->filled('id_number')) {
            $rules['id_number'] = 'string|max:50|unique:users,id_number';
        }

        // نفّذ التحقق
        $request->validate($rules, [
            'name.required' => 'يجب إدخال الاسم',
            'username.unique' => 'البريد الإلكتروني مستخدم بالفعل',
            'username.email' => 'يجب أن يكون البريد الإلكتروني بصيغة صحيحة',
            'id_number.unique' => 'رقم الهوية مستخدم بالفعل',
            'password.required' => 'يجب إدخال كلمة المرور',
            'password.min' => 'يجب أن تحتوي كلمة المرور على 6 أحرف على الأقل',
            'gender.required' => 'يجب تحديد الجنس',
            'area_id.required' => 'يجب اختيار المنطقة',
            'area_id.exists' => 'المنطقة المختارة غير موجودة',
        ]);

        // خزن الصورة إذا وجدت
        $path = $request->file('profile_picture')
            ? $request->file('profile_picture')->store('avatars', 'public')
            : 'defaults/profile.jpg';

        // إنشاء المستخدم
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'id_number' => $request->id_number,
            'password' => bcrypt($request->password),
            'gender' => $request->gender,
            'area_id' => $request->area_id,
            'profile_picture' => $path,
        ]);

        // تسجيل الدخول مباشرة بعد الإنشاء
        Auth::login($user);

        // تحويل للموقع الرئيسي أو لوحة التحكم
        return redirect()->route('dashboard')->with('success', 'تم إنشاء الحساب بنجاح!');
    }


    public function login(Request $request)
    {
        // 1. Validate the single incoming field: 'username' (which holds either email or ID)
        $request->validate([
            'username' => 'required|string|max:255', // Now it's simply 'required'
            'password' => 'required|string'
        ], [
            'username.required' => 'يجب إدخال البريد الإلكتروني أو رقم الهوية',
            'password.required' => 'يجب إدخال كلمة المرور'
        ]);

        // 2. Retrieve the input value for the username/id_number
        $input_identifier = $request->username;

        // 3. Query the database, checking the input against BOTH 'username' and 'id_number'
        $user = User::where('username', $input_identifier)
            ->orWhere('id_number', $input_identifier)
            ->first();

        // The rest of the logic remains the same
        if (!$user) {
            return back()->withErrors(['login' => 'هذا الحساب غير موجود'])->withInput();
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['login' => 'كلمة السر غير صحيحة'])->withInput();
        }

        if (!$user->is_active) {
            return back()->withErrors(['login' => 'هذا الحساب غير مفعل'])->withInput();
        }

        Auth::login($user);

        switch ($user->role) {
            case 'admin': return redirect()->route('admin');
            case 'employee': return redirect()->route('employee');
            case 'employee_services': return redirect()->route('employee_s');
            case 'patient': return redirect()->route('patient');
        }
    }



    public function dashboard()
    {
        $user = Auth::user();

        if (!$user || $user->role !== "patient") {
            return redirect()->route('log_form');
        }

        if (!$user->patient || !$user->patient->profile_completed) {
            return redirect()->route('families.create');
        }

        return view('patient.patient');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function log_form()
    {
        return view('user.log_form');
    }

    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username,' . $user->id,
            'id_number' => 'nullable|string|max:50|unique:users,id_number,' . $user->id,
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ], [
            'name.required' => 'الاسم مطلوب.',
            'username.unique' => 'البريد الإلكتروني مستخدم مسبقًا.',
            'id_number.unique' => 'رقم الهوية مستخدم مسبقًا.',
            'profile_picture.image' => 'يجب أن تكون الصورة من نوع صورة.',
            'profile_picture.mimes' => 'نوع الصورة يجب أن يكون jpg، jpeg، png أو gif.',
            'profile_picture.max' => 'حجم الصورة لا يجب أن يتجاوز 2 ميجابايت.',
        ]);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->id_number = $request->id_number;

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            $user->profile_picture = $request->file('profile_picture')->store('avatars', 'public');
        }

        $user->save();

        return back()->with('success', 'تم تحديث الحساب بنجاح.');
    }

    public function employee()
    {
        return view('employee.employee');
    }

    public function patient()
    {
        return view('patient.patient');
    }

    public function employee_s()
    {
        return view('employee_s.employee_s');
    }
}

