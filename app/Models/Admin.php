<?php

namespace App\Models;


class Admin extends User {

    protected static function boot() {
        parent::boot();

        static::addGlobalScope('admin', function ($builder) {
            $builder->where('is_admin', true);
        });
    }
}
