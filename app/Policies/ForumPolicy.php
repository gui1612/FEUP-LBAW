<?php

namespace App\Policies;

use App\Models\Forum;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForumPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Forum $forum)
    {
        return true;
    }

    public function follow(User $user, Forum $target)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function edit(User $user, Forum $target)
    {
        return $target->owners()->find($user->id);
    }

    public function promote(User $user, Forum $target)
    {
        return $target->owners()->find($user->id);
    }

    public function demote(User $user, Forum $target)
    {
        return $target->owners()->find($user->id);
    }

    public function delete(User $user, Forum $target)
    {
        return $target->owners()->find($user->id);
    }
}
