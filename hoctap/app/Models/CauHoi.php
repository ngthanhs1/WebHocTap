<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CauHoi extends Model
{
    protected $fillable = ['de_thi_id','noi_dung','giai_thich','do_kho'];

    public function deThi()  { return $this->belongsTo(DeThi::class); }
    public function dapAns() { return $this->hasMany(DapAn::class); }
}
