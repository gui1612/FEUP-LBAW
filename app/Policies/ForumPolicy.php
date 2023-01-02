<?php

namespace App\Policies;

use App\Models\Forum;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ForumPolicy
{
    use HandlesAuthorization;


    public function view(?User $user, Forum $forum)
    {
        return true;
    }

    public function follow(User $user, Forum $target)
    {
        return !$target->followers()->where('users.id', $user->id)->count();
    }

    public function unfollow(User $user, Forum $target)
    {
        return !static::follow($user, $target);
    }

    public function create(User $user)
    {
        return true;
    }

    public function edit(User $user, Forum $target)
    {
        return $user->is_admin || $target->owners()->find($user->id);
    }

    public function promote(User $user, Forum $target)
    {
        return $user->is_admin || $target->owners()->find($user->id);
    }

    public function demote(User $user, Forum $target)
    {
        if ($target->owners->count() <= 1)
            return Response::denyWithStatus(403, 'A forum must have at least one owner.');

        return $user->is_admin || $target->owners()->find($user->id);
    }

    public function delete(User $user, Forum $target)
    {
        return !$target->owners->where('users.id', $user->id)->count();
    }
}
