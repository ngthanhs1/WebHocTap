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
        try {
            $cred = $request->validate([
                'usergmail' => ['required','string','max:50'],
                'password'  => ['required','string'],
                'remember'  => ['nullable','boolean'],
            ]);

            $remember = (bool)($cred['remember'] ?? false);
            $loginField = $cred['usergmail'];
            $password = $cred['password'];

            // Xác định xem người dùng nhập username hay email
            $fieldType = filter_var($loginField, FILTER_VALIDATE_EMAIL) ? 'usergmail' : 'username';
            
            // Thử đăng nhập với field type tương ứng
            if (Auth::attempt([$fieldType => $loginField, 'password' => $password], $remember)) {
                $request->session()->regenerate();
                return redirect()->intended(route('trangchinh'))
                       ->with('ok','Đăng nhập thành công');
            }

            return back()->withErrors([
                'usergmail' => 'Tài khoản hoặc mật khẩu không đúng.',
            ])->onlyInput('usergmail');
            
        } catch (\Illuminate\Session\TokenMismatchException $e) {
            return back()->withErrors([
                'usergmail' => 'Phiên đăng nhập đã hết hạn. Vui lòng thử lại.',
            ])->onlyInput('usergmail');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('ok','Đã đăng xuất');
    }
}
