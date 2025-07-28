<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


class AdminController extends Controller
{

    public function admin()
    {
            return view('admin.admin');

    }
    public function role()
    {
        $users = User::where('username', '!=', 'ali@gmail.com')
            ->orderBy('id', 'desc')
            ->get(); // استثناء الأدمن من القائمة
        return view('admin.role', compact('users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:admin,employee,employee_services,patient',
        ]);

        $user = User::findOrFail($id);

        // منع الأدمن من تعديل دوره الخاص
        if (auth()->user()->id == $user->id) {
            return redirect()->back()->with('error', 'لا يمكنك تغيير دورك الشخصي.');
        }

        $user->role = $request->role;
        $user->save();

        return redirect()->back()->with('success', 'تم تحديث دور المستخدم بنجاح.');
    }

    public function search(Request $request)
    {
        $query = $request->query('query');

        $users = User::where('username', '!=', 'ali@gmail.com')
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('id', 'like', "%{$query}%")
                    ->orwhere('username', 'like', "%{$query}%");
            })
            ->orderBy('id', 'desc') // لضمان إظهار آخر مضاف أولًا
            ->get();

        return view('admin.table', compact('users'));
    }


    public function active($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();
        return redirect()->back()->with('status', 'تم تعديل حالة الحساب.');
    }

}



