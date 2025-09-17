<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['topic_id', 'content'];

    // Quan hệ
    public function topic()   { return $this->belongsTo(Topic::class); }
    public function choices() { return $this->hasMany(Choice::class); }

    // Helper: ID đáp án đúng (nếu bạn thiết kế 1 đáp án đúng)
    public function correctChoiceId(): ?int
    {
        $choice = $this->choices()->where('is_correct', true)->first();
        return $choice?->id;
    }
}
