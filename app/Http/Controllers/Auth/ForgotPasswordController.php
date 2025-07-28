<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('user.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([ 'username' => 'required|email|exists:users,username'
        ], [
        'username.required' => 'يجب إدخال البريد الإلكتروني',
        'username.email' => 'يجب إدخال بريد إلكتروني صحيح',
        'username.exists' => 'هذا الحساب غير موجود  ',
    ]);

        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return back()->withErrors(['username' => 'المستخدم غير موجود']);
        }

        $status = Password::sendResetLink(
            ['username' => $request->username]
        );



        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['username' => __($status)]);
    }
}
