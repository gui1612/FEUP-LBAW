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
    ];

    public function owners()
    {
        return $this->belongsToMany(User::class, 'owner_id', 'id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'forum_id', 'id');
    }

    public function followers()
    {
        return $this->hasMany(Follow::class, 'followed_forum_id', 'id');
    }

    public function scopeVisible($query)
    {
        return $query->where('hidden', false);
    }

    public function getForumPictureOrDefaultUrl()
    {
        if (is_null($this->profile_picture)) {
            return mix('images/defaults/user.png');
        }

        return str_starts_with($this->profile_picture, 'http') ? $this->profile_picture : asset('/storage/' . $this->profile_picture);
    }

    public function getBannerPictureUrl()
    {
        if (is_null($this->banner_picture)) {
            return mix('images/defaults/banner.jpg');
        }
        return str_starts_with($this->banner_picture, 'http') ? $this->banner_picture : asset('/storage/' . $this->banner_picture);
    }
}
