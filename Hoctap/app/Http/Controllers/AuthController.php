<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $cred = $request->validate([
            'usergmail' => ['required','string','max:50'],
            'password'  => ['required','string'],
            'remember'  => ['nullable','boolean'],
        ]);

        $remember = (bool)($cred['remember'] ?? false);
        unset($cred['remember']);

        if (Auth::attempt(['usergmail' => $cred['usergmail'], 'password' => $cred['password']], $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('thongke.index'))
                   ->with('ok','Đăng nhập thành công');
        }

        return back()->withErrors([
            'usergmail' => 'Tài khoản hoặc mật khẩu không đúng.',
        ])->onlyInput('usergmail');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('ok','Đã đăng xuất');
    }
}
