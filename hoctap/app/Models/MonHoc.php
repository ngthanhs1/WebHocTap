<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonHoc extends Model
{
    protected $fillable = ['ten','mo_ta'];

    public function deThis()
    {
        return $this->hasMany(DeThi::class);
    }
}
