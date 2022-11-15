<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';


    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

   /* public function followedBy()  
    {
        return $this->belongsTo(User::class, 'Follows', 'followedUser','ownerId');
    }

    public function following()
    {
        return $this->belongsTo(User::class, 'Follows', 'ownerId', 'followedUser');
    }

    public function isFollowing($userId) 
    {
        $isFollowing = $this->following->where('ownerId',$userId);
        return count($isFollowing) > 0; 
    }

    public function reports() 
    {
        return $this->hasMany(Report::class);
    }

    public function notifications() 
    {
        return $this->hasMany(Notification::class);
    }

    public function comments() 
    {
        return $this->hasMany(Comment::class);
    }

    public function posts() {
        return $this->hasMany(Post::class);
    }
    */
}
