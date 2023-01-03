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

    public function body() {
        //'follow_user', 'post_comment', 'content_reported', 'content_rated'
        if ($this->type == 'follow_user') {
            return '@' . $this->follow->owner->username . ' started following you!';
        } else if ($this->type == 'content_reported') {
            return 'Someone just reported your content';
        } else if ($this->type == 'post_comment') {
            return '@' . $this->comment->owner->username . ' commented on your post';
        } else if ($this->type == 'content_rated') {
            if ($this->rating->type == 'like') {
                if ($this->rating->post != NULL) {
                    return '@' . $this->rating->owner->username . ' just liked your post';
                } else {
                    return '@' . $this->rating->owner->username . ' just liked your comment';
                }
            } else {
                if ($this->rating->post != NULL) {
                    return '@' . $this->rating->owner->username . ' just disliked your post';
                } else {
                    return '@' . $this->rating->owner->username . ' just disliked your comment';
                }
            }
        }
    }

    public function link() {
        if ($this->type == 'follow_user') {
            return route('user.show', ['user'=>$this->follow->owner]);

        } else if ($this->type == 'content_reported') {
            if ($this->report->post != NULL) {
                return route('post', ['forum' => $this->report->post->forum, 'post'=>$this->report->post]);
            } elseif ($this->report->comment != NULL) {
                return route('post', ['forum' => $this->report->comment->post->forum, 'post'=>$this->report->comment->post]);
            } else {
                return route('forum.show', ['forum'=>$this->report->forum]);
            }

        } else if ($this->type == 'post_comment') {
            return route('post', ['forum' => $this->comment->post->forum, 'post'=>$this->comment->post]);

        } else if ($this->type == 'content_rated') {
            if ($this->rating->post != NULL) {
                return route('post', ['forum' => $this->rating->post->forum, 'post'=>$this->rating->post]);
            } else {
                return route('post', ['forum' => $this->rating->comment->post->forum, 'post'=>$this->rating->comment->post]);
            }
        }
    }
}
