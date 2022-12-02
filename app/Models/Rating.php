<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'ratings';

    protected $hidden = ['id'];
    protected $guarded = [];
    
    public function owner() {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function post() {
        return $this->belongsTo(Post::class, 'rated_post_id');
    }

    public function comment() {
        return $this->belongsTo(Comment::class, 'rated_comment_id');
    }
}
