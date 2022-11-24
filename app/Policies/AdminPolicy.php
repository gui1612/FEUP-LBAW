<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability) {
        if ($user->is_deleted() || !$user->is_admin) {
            return false;
        } 
    }

    public function demote(User $user, Admin $target) {
        return true;
    }
}
