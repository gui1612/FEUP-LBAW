<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'notifications';

    protected $casts = [
        'created_at' => 'datetime',
        'last_edited' => 'datetime'
    ];

    public function owner() {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function follow() {
        return $this->belongsTo(Follow::class, 'follow_id');
    }

    public function comment() {
        return $this->belongsTo(Comment::class, 'comment_id');
    }

    public function report() {
        return $this->belongsTo(Report::class, 'report_id');
    }

    public function rating() {
        return $this->belongsTo(Rating::class, 'rating_id');
    }
}
