<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeThi extends Model
{
    protected $table = 'de_this';
    protected $fillable = ['mon_hoc_id','tieu_de','mo_ta','cong_khai'];

    public function monHoc(){ return $this->belongsTo(MonHoc::class); }
    public function cauHois(){ return $this->hasMany(CauHoi::class); }

    // tiện lọc cho trang catalog
    public function scopeCongKhai($q){ return $q->where('cong_khai', true); }
    public function scopeFilter($q, $params){
        return $q
          ->when($params['mon_hoc_id'] ?? null, fn($qq,$v)=>$qq->where('mon_hoc_id',$v))
          ->when($params['q'] ?? null, fn($qq,$v)=>$qq->where('tieu_de','like',"%$v%"));
    }
}
