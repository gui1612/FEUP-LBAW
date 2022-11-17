<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    public $timestamps  = false;

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
