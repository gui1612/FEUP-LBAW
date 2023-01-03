<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    public function login(User $user) {
        if (!$user->is_blocked)
            return Response::denyWithStatus(403, 'This account is block');
        return true;
    }
}
