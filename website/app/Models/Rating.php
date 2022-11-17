<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    public $primaryKey = ['owner_id', 'rated_post_id'];
    public $incrementing = false;

    public function owner() {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }
}
