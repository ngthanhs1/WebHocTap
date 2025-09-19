<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class Topic extends Model
{
    use HasFactory;

    // Cho phép gán các cột này khi create/update
    protected $fillable = ['user_id', 'name', 'slug'];

    // ─── Quan hệ ────────────────────────────────────────────────────────────────
    public function user()      { return $this->belongsTo(User::class, 'user_id', 'usergmail'); }
    public function questions() { return $this->hasMany(Question::class); }
    public function sessions()  { return $this->hasMany(PracticeSession::class); }

    // ─── Scopes tiện dụng ──────────────────────────────────────────────────────
    /** Lọc theo chủ sở hữu */
    public function scopeOwnedBy($q, int $userId) {
        return $q->where('user_id', $userId);
    }

    /**
     * Trả về thống kê gọn cho bảng báo cáo:
     *  - attempts_count  (số lần làm)
     *  - accuracy_percent (% đúng, tổng score / tổng total_questions)
     *  - topic_created_at (thời gian tạo chủ đề)
     */
    public function scopeWithReportForUser($q, int $userId) {
        return $q
            ->select('topics.*')
            ->leftJoin('practice_sessions as ps', function ($join) use ($userId) {
                $join->on('ps.topic_id', '=', 'topics.id')
                     ->where('ps.user_id', '=', $userId);
            })
            ->addSelect([
                'attempts_count'   => DB::raw('COUNT(ps.id)'),
                'accuracy_percent' => DB::raw('ROUND( (CASE WHEN COALESCE(SUM(ps.total_questions),0)=0 THEN 0 ELSE SUM(ps.score)/SUM(ps.total_questions)*100 END), 2 )'),
                'topic_created_at' => 'topics.created_at',
            ])
            ->groupBy('topics.id', 'topics.name', 'topics.slug', 'topics.user_id', 'topics.created_at', 'topics.updated_at');
    }

    // ─── Tự tạo slug duy nhất trong phạm vi 1 user ────────────────────────────
    protected static function boot()
    {
        parent::boot();

        static::creating(function (Topic $topic) {
            if (empty($topic->slug) && !empty($topic->name)) {
                $base = Str::slug($topic->name);
                $slug = $base;
                $i = 1;

                while (static::where('user_id', $topic->user_id)->where('slug', $slug)->exists()) {
                    $slug = $base.'-'.$i++;
                }
                $topic->slug = $slug;
            }
        });
    }
}
