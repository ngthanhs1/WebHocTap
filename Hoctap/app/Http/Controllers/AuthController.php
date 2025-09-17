<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        // nếu đã đăng nhập thì đẩy về trang chính
        if (Auth::check()) return redirect()->route('thongke.index');
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $cred = $request->validate([
            'email'    => ['required','email'],
            'password' => ['required','string'],
            'remember' => ['nullable','boolean'],
        ]);

        $remember = (bool)($cred['remember'] ?? false);
        unset($cred['remember']);

        if (Auth::attempt($cred, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('thongke.index'))
                   ->with('ok','Đăng nhập thành công');
        }

        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không đúng.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('ok','Đã đăng xuất');
    }
}
