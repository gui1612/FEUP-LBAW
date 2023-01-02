<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'posts';

    protected $casts = [
        'created_at' => 'datetime',
        'last_edited' => 'datetime'
    ];

    public function forum() {
        return $this->belongsTo(Forum::class, 'forum_id');
    }

    public function owner() {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function images() {
        return $this->hasMany(PostImage::class, 'post_id');
    }

    public function forum_name(int $id) {
        $forum = Forum::find($id);
        return $forum->name;
    }

    public function ratings() {
        return $this->hasMany(PostRating::class, 'rated_post_id');
    }

    public function comments() {
        return $this->hasMany(Comment::class, 'post_id');
    }

    public function scopeVisible($query) {
        return $query->where('hidden', false);
    }

    public function displayDate($date) {
        return Carbon::parse($date)->diffForHumans();
    }
}
