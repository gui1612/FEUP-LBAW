<?php

namespace App\Models;

class CommentRating extends Rating
{

    protected $hidden = ['rated_post_id', 'id'];
    
    public static function boot() {
        parent::boot();

        static::addGlobalScope(function ($builder) {
            $builder->whereNotNull('rated_comment_id');
        });

        static::saving(function ($rating) {
            $rating->rated_post_id = null;
        });
    }
}
