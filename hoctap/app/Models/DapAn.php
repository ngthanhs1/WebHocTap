<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DapAn extends Model
{
    protected $fillable = ['cau_hoi_id','noi_dung','dung'];

    public function cauHoi() { return $this->belongsTo(CauHoi::class); }
}
