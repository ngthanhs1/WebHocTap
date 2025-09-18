<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showForm()
    {
        return view('logout');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'fullName' => 'required|string|max:50',
            'email' => 'required|string|email|max:50|unique:users,usergmail',
            'password' => 'required|string|min:6|confirmed',
            'agreeTerms' => 'accepted',
        ], [
            'email.unique' => 'Email đã tồn tại.',
            'agreeTerms.accepted' => 'Bạn phải đồng ý với điều khoản.'
        ]);

        $user = new User();
        $user->usergmail = $validated['email'];
        $user->username = $validated['fullName'];
        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->route('login')->with('ok', 'Đăng ký thành công! Vui lòng đăng nhập.');
    }
}
