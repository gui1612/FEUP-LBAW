<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $visible = [];/*[
        'created_at',
        'username',
        'first_name',
        'last_name',
        'bio',
        'reputation',
        'profile_picture',
        'banner_picture',
    ];*/


    public function followed_by() {
        return $this->belongsToMany(User::class, 'follows', 'followed_user_id', 'owner_id');
    }

    public function followed_users() {
        return $this->belongsToMany(User::class, 'follows', 'owner_id', 'followed_user_id')->wherePivotNotNull('followed_user_id');
    }

    public function followed_forums() {
        return $this->belongsToMany(Forum::class, 'follows', 'owner_id', 'followed_forum_id')->wherePivotNotNull('followed_forum_id');
    }

    public function owned_forums() {
        return $this->belongsToMany(Forum::class, 'forumowners', 'owner_id', 'forum_id');
    }
}
