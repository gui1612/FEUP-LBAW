<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    
    use HasFactory;

    public $timestamps = false;

    public function forumOwner() {
        return $this->belongsTo(User::class);
    }
    
    public function reports() {
        return $this->hasMany(Report::class);
    }

    /* I have doubts about this one, also the reverse 
     need to be done */
    public function follows() {
        return $this->hasMany(Follow::class);
    }

}
