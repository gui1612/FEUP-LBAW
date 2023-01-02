<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'reports';

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function owner() {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function forum() {
        return $this->belongsTo(Forum::class, 'forum_id');
    }

    public function comment() {
        return $this->belongsTo(Comment::class, 'comment_id');
    }

    public function post() {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function scopeVisible($query) {
        return $query->where('archived', false);
    }

    public function displayDate($date) {
        return Carbon::parse($date)->diffForHumans();
    }
}
