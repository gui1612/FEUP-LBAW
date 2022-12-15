<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'forums';

    protected $casts = [
        'created_at' => 'datetime',
        'last_edited' => 'datetime'
    ];

    public function owner() {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function posts() {
        return $this->hasMany(Post::class, 'forum_id');
    }

    public function scopeVisible($query) {
        return $query->where('hidden', false);
    }
}
