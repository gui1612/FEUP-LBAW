<?php

namespace App\Models;


class DeletedUser extends User {

    protected $visible = [
        'id',
        'username'
    ];

    public static function boot() {
        parent::boot();

        static::addGlobalScope('deleted_user', function ($builder) {
            $builder->whereNull('email');
        });
    }
}
