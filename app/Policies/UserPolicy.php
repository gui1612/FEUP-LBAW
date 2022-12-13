<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability) {
        if ($user->is_deleted()) {
            return false;
        }
    }

    public function promote(User $user, User $target) {
        return $user->is_admin && !$target->is_admin;
    }

    public function view(?User $user, User $target) {
        return true;
    }
    
    public function edit(User $user, User $target) {
        return $user->is_admin || $user->id === $target->id;
    }

    public function follow(User $user, User $target) {
        return true;
    }
}
