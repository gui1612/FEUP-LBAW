<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    
    use HasFactory;

    public $timestamps = false;

    public function owners() {
        return $this->belongsToMany(User::class, 'forumowners', 'forum_id', 'owner_id');
    }
    
    // public function reports() {
    //     return $this->hasMany(Report::class);
    // }

    public function followed_by() {
        return $this->hasMany(User::class);
    }

}
