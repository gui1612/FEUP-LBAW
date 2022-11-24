<?php

namespace App\Models;

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

    public function owner() {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function images() {
        return $this->hasMany(PostImage::class, 'post_id');
    }

    public function ratings() {
        return $this->hasMany(PostRating::class, 'rated_post_id');
    }
}
