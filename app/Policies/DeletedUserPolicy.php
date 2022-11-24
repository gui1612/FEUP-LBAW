<?php

namespace App\Policies;

use App\Models\DeletedUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeletedUserPolicy
{
    use HandlesAuthorization;

    public function before(User $user) {
        if ($user->is_deleted()) {
            return false;
        }
    }
}
