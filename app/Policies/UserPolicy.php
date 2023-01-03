<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability) {
        if ($user->is_deleted()) {
            return false;
        }
    }

    public function block(User $user, User $target) {
        if ($user === $target)
            return Response::denyWithStatus(403, 'You can\'t block yourself.');

        if ($target->is_admin)
            return Response::denyWithStatus(403, 'You can\'t block an administrator.');
   
        return $user->is_admin && !$target->is_blocked();
    }

    public function unblock(User $user, User $target) {
        if ($user === $target)
            return Response::denyWithStatus(403, 'You can\'t unblock yourself.');
            
        return $user->is_admin && $target->is_blocked();
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

    public function delete(User $user, User $target) {
        if ($target->is_admin)
            return Response::denyWithStatus(403, 'An admin account cannot be deleted.');

        return $user->id == $target->id;
    }
}
