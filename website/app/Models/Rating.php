<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    public $timestamps = false;

    public function owner() {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }
}
