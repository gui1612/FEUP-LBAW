<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function owner() {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    public function post() {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

}
