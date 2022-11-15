<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    
    use HasFactory;

    public $timestamps = false;

    public function comment_owner() {
        return $this->belongsTo(User::class);
    }
}
