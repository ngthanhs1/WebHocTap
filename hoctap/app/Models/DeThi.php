<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeThi extends Model
{
    protected $table = 'de_this';
    protected $fillable = ['user_id','mon_hoc_id','tieu_de','mo_ta','cong_khai'];

    public function user()   { return $this->belongsTo(User::class); }
    public function monHoc() { return $this->belongsTo(MonHoc::class); }
    public function cauHois(){ return $this->hasMany(CauHoi::class); }

    // chỉ lấy quiz của user hiện tại
    public function scopeCuaToi($q){ return $q->where('user_id', auth()->id()); }

    // tìm kiếm + lọc + sort đơn giản
    public function scopeSearch($q,$t){
        $t = trim($t ?? '');
        return $t==='' ? $q : $q->where(fn($qq)=>$qq
            ->where('tieu_de','like',"%$t%")
            ->orWhere('mo_ta','like',"%$t%"));
    }
    public function scopeFilter($q,$p){
        return $q
            ->when($p['mon_hoc_id']??null, fn($qq,$v)=>$qq->where('mon_hoc_id',$v))
            ->when(($p['trang_thai']??'')!=='', function($qq) use($p){
                return $p['trang_thai']==='published' ? $qq->where('cong_khai',1) : $qq->where('cong_khai',0);
            })
            ->when($p['sort']??null, function($qq) use($p){
                return match($p['sort']){
                    'oldest' => $qq->oldest(),
                    'title_asc' => $qq->orderBy('tieu_de'),
                    'title_desc'=> $qq->orderByDesc('tieu_de'),
                    default => $qq->latest(),
                };
            }, fn($qq)=>$qq->latest());
    }
}