<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'User'; // Trỏ đến bảng User trong MySQL
    protected $primaryKey = 'usergmail';
    public $incrementing = false;
    protected $keyType = 'string';
    
    const UPDATED_AT = null; // Không sử dụng updated_at vì bảng MySQL không có
    
    // Tắt remember token vì bảng MySQL không có cột này
    public function getRememberToken()
    {
        return null;
    }
    
    public function setRememberToken($value)
    {
        // Không làm gì cả
    }
    
    public function getRememberTokenName()
    {
        return null;
    }

    protected $fillable = [
        'usergmail',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
