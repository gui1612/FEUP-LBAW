<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasFactory;

    protected $table = 'Users';


    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'first_name', 'last_name', 'banner_Picture' ,'email',
        'password', 'bio'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function followedBy()  
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


    public function isAdmin() {
        return $this->isAdmin == true;
    }

    
}
