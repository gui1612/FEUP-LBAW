<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'postimages';

    public function post() {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
}