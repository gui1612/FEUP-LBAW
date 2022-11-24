<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;

class Admin extends User {

    protected static function boot() {
        parent::boot();

        static::addGlobalScope(function ($builder) {
            $builder->where('is_admin', true);
        });
    }
}
