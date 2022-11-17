<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function owner() {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    public function forum() {
        return $this->belongsTo(Forum::class, 'forum_id', 'id');
    }

    public function comments() {
        return $this->hasMany(Comment::class, 'post_id', 'id'); 
    }

    public function images() {
        return $this->hasMany(PostImage::class, 'post_id', 'id');
    }

    public function ratings() {
        return $this->hasMany(Rating::class, 'post_id', 'id');
    }
}
