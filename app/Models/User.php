<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as AuthUser;

class User extends AuthUser {
    use HasFactory;

    public $timestamps = false;
    protected $table = 'users';

    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'bio',
        'profile_picture',
        'banner_picture',
        'provider',
        'provider_id',
    ];

    protected $hidden = [
        'is_admin',
        'password',
        'remember_token',
        'provider',
        'provider_id',
    ];
    
    public function profile_picture_or_default_url() {
        if (is_null($this->profile_picture)) {
            return mix('images/defaults/user.png');
        }
        
        return str_starts_with($this->profile_picture, 'http') ? $this->profile_picture : asset('/storage/' . $this->profile_picture);
    }

    public function banner_picture_url() {
        if (is_null($this->banner_picture)) {
            return mix('images/defaults/banner.jpg');
        }

        return str_starts_with($this->banner_picture, 'http') ? $this->banner_picture : asset('/storage/' . $this->banner_picture); 
    }

    public function posts() {
        return $this->hasMany(Post::class, 'owner_id', 'id');
    }

    public function rated_posts() {
        return $this->belongsToMany(Post::class, 'ratings', 'owner_id', 'rated_post_id');
    }

    public function comments() {
        return $this->hasMany(Comment::class, 'owner_id', 'id');
    }

    public function followers() {
        return $this->hasMany(Follow::class, 'followed_user_id', 'id');
    }

    public function follows() {
        return $this->hasMany(Follow::class, 'owner_id', 'id');
    }

    public function is_deleted() {
        return is_null($this->email);
    }

    public function scopeActive($query) {
        return $query->whereNotNull('email');
    }
}
