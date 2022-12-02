<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model {
    use HasFactory;

    public $timestamps = false;
    protected $table = 'comments';

    protected $casts = [
        'created_at' => 'datetime',
        'last_edited' => 'datetime'
    ];

    public function owner() {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function post() {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function ratings() {
        return $this->hasMany(CommentRating::class, 'rated_comment_id');
    }

    public function scopeVisible($query) {
        return $query->where('hidden', false);
    }
}
