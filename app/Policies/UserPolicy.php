<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;
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

        return $user->is_admin;
    }

    public function delete_post(User $user, Post $post) {
        if ($post->hidden) {
            if ($user->id === $post->owner_id) {
                return Response::denyWithStatus(403, 'You cannot delete a hidden post.');
            }
        
            return Response::denyAsNotFound();
        }
        
        if ($post->owner_id !== $user->id) {
            return Response::denyWithStatus(403, 'You are not the owner of this post.');
        }
        
        if ($post->ratings->count() > 0) {
            return Response::denyWithStatus(403, 'You cannot delete a post that has ratings.');
        }

        if ($post->comments->count() > 0) {
            return Response::denyWithStatus(403, 'You cannot delete a post that has comments.');
        }
        
        return true;
    }
}
