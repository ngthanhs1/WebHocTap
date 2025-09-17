<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ThongKe extends Model
{
    use HasFactory;

    protected $table = 'thongke';

    protected $fillable = [
        'user_id','topic_id','score','total_questions',
        'started_at','finished_at'
    ];

    protected $casts = [
        'started_at'  => 'datetime',
        'finished_at' => 'datetime',
    ];

    public function user(){ return $this->belongsTo(User::class); }
    public function topic(){ return $this->belongsTo(Topic::class); }

    // % đúng = score / total_questions * 100
    public function getAccuracyAttribute(): float
    {
        return $this->total_questions > 0
            ? round($this->score * 100 / $this->total_questions, 2)
            : 0.0;
    }
}
