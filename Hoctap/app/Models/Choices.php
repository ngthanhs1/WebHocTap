<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Choices extends Model
{
    use HasFactory;

    protected $fillable = ['question_id', 'content', 'is_correct'];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    // Quan hệ
    public function question() { return $this->belongsTo(Question::class); }
}
