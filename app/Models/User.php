<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as AuthUser;

class User extends AuthUser {
    use HasFactory;

    public $timestamps = false;
    protected $table = 'users';

    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    protected $hidden = [
        'is_admin',
        'password',
        'remember_token',
    ];

    public function profile_picture_or_default() {
        return $this->profile_picture ?? mix('images/defaults/user.png');
    }

    public function posts() {
        return $this->hasMany(Post::class, 'owner_id', 'id');
    }

    public function rated_posts() {
        return $this->hasMany(Rating::class, 'owner_id', 'id');
    }

    public function is_deleted() {
        return is_null($this->email);
    }
}
