<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'follows';

    protected $hidden = ['id'];
    protected $guarded = [];

    public function owner() {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'followed_user_id');
    }
    
    public function forum() {
        return $this->belongsTo(User::class, 'followed_forum_id');
    }
}