<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class QuickPasswordController extends Controller
{
    protected function tablesToCheck(): array
    {
        $tables = [];
        if (Schema::hasTable('users')) $tables[] = 'users';
        if (Schema::hasTable('User'))  $tables[] = 'User';
        return $tables ?: ['users'];
    }

    public function showForm()
    {
        return view('auth.quick-reset');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'email' => ['required','email','max:255'],
            'password' => ['required','string','min:6','confirmed'],
        ]);

        // Chuẩn hóa email: trim + lowercase
        $email = strtolower(trim((string)$data['email']));

        $tables = $this->tablesToCheck();
        $updated = 0;

        foreach ($tables as $table) {
            // Thử so khớp không phân biệt hoa/thường nếu DB hỗ trợ, fallback so khớp lowercase thủ công
            $query = DB::table($table);
            $exists = $query->whereRaw('LOWER(usergmail) = ?', [$email])->exists();
            if (!$exists) continue;

            $payload = ['password' => Hash::make($data['password'])];
            if (Schema::hasColumn($table, 'remember_token')) {
                $payload['remember_token'] = Str::random(60);
            }

            $updated += DB::table($table)->whereRaw('LOWER(usergmail) = ?', [$email])->update($payload);
        }

        if ($updated === 0) {
            return back()->withErrors(['email' => 'Email không tồn tại trong hệ thống.'])->onlyInput('email');
        }

        return redirect()->route('login')->with('ok', 'Đã cập nhật mật khẩu thành công. Vui lòng đăng nhập.');
    }
}
