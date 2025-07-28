<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function reg_form()
    {
        return view('user.reg_form',['areas'=>Area::all()]);
    }

    public function register(Request $request)
    {
      //  dd($request->all());

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|email|max:255|unique:users,username',
            'password' => 'required|string|min:6',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',

        ], [
            'name.required' => 'يجب إدخال الاسم',
            'username.required' => 'يجب إدخال البريد الإلكتروني',
            'username.email' => 'يجب إدخال بريد إلكتروني صحيح',
            'username.unique' => 'البريد الإلكتروني مستخدم بالفعل',
            'password.required' => 'يجب إدخال كلمة المرور',
            'password.min' => 'يجب أن تحتوي كلمة المرور على 6 أحرف على الأقل',
            'profile_picture.image' => 'يجب أن يكون الملف صورة.',
            'profile_picture.mimes' => 'يجب أن تكون الصورة من نوع: jpg, jpeg, png, gif.',
            'profile_picture.max' => 'يجب ألا يزيد حجم الصورة عن 2 ميجابايت.',

        ]);

        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('avatars', 'public');
        } else {
            $path = 'defaults/profile.jpg';
        }

        $name = $request->name;
        $username = $request->username;
        $password = $request->password;
        $gender = $request->gender;
        $area_id = $request->area_id;

        $data = [
            'name'=>$name,
            'username'=>$username,
            'password' => bcrypt($password),
            'gender'=>$gender,
            'area_id'=>$area_id,
            'profile_picture'=>$path,
        ];

        $user = User::create($data);

        Auth::login($user);
        return redirect()->route('dashboard');
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
    public function login(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|email|exists:users,username', // التأكد من أن المدخل بريد إلكتروني
            'password' => 'required|string'
        ], [
            'username.required' => 'يجب إدخال البريد الإلكتروني',
            'username.email' => 'يجب إدخال بريد إلكتروني صحيح',
            'username.exists' => 'هذا الحساب غير موجود  ',
            'password.required' => 'يجب إدخال كلمة المرور',
        ]);


        $user =User::where('username', $request->username)->first();

        if (!$user->is_active) {
            return back()->withErrors(['username' => 'هذا الحساب غير مفعل'])->withInput();
        }
        if (Auth::attempt($data)) {
            $user = Auth::user(); // الحصول على المستخدم المصادق عليه

            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin');
                case 'employee':
                    return redirect()->route('employee');
                case 'employee_services':
                    return redirect()->route('employee_s');
                case 'patient':
                    return redirect()->route('patient');
            }
        }

        return redirect()->route('log_form')->withErrors(['خطأ' => 'كلمة السر غير صحيحة'])->withInput();

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
            'username' => 'required|email|max:255|unique:users,username,' . $user->id,
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ], [
            'name.required' => 'الاسم مطلوب.',
            'name.string' => 'الاسم يجب أن يكون نصًا.',
            'name.max' => 'الاسم لا يمكن أن يزيد عن 255 حرفًا.',

            'username.required' => 'البريد الإلكتروني مطلوب.',
            'username.email' => 'يجب إدخال بريد إلكتروني صالح.',
            'username.max' => 'البريد الإلكتروني لا يمكن أن يزيد عن 255 حرفًا.',
            'username.unique' => 'البريد الإلكتروني مستخدم مسبقًا.',

            'profile_picture.image' => 'يجب أن تكون الصورة من نوع صورة.',
            'profile_picture.mimes' => 'نوع الصورة يجب أن يكون jpg، jpeg، png أو gif.',
            'profile_picture.max' => 'حجم الصورة لا يجب أن يتجاوز 2 ميجابايت.',
        ]);

        $user->name = $request->name;
        $user->username = $request->username;

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            $path = $request->file('profile_picture')->store('avatars', 'public');
            $user->profile_picture = $path;
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
