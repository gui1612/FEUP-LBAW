<?php

namespace App\Models;

class PostRating extends Rating
{

    protected $hidden = ['rated_comment_id', 'id'];
    
    public static function boot() {
        parent::boot();

        static::addGlobalScope(function ($builder) {
            $builder->whereNotNull('rated_post_id');
        });

        static::saving(function ($rating) {
            $rating->rated_comment_id = null;
        });
    }
}
