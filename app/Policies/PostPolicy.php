<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class PostPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability) {
        if ($user->is_deleted()) {
            return false;
        }

        if ($user->is_admin) {
            return true;
        }
    }

    public function create(User $user) {
        return true;
    }

    public function view(?User $user, Post $post) {
        if ($post->hidden && $user->id !== $post->owner_id) {
            return Response::denyAsNotFound();
        }
        
        return true;
    }
    
    public function edit(User $user, Post $post) {
        if ($post->hidden) {
            if ($user->id === $post->owner_id) {
                return Response::denyWithStatus(403, 'You cannot edit a hidden post.');
            }
        
            return Response::denyAsNotFound();
        }

        if ($user->id !== $post->owner_id) {
            return Response::denyWithStatus(403, 'You are not the owner of this post.');
        }
        
        return true;
    }
    
    public function delete(User $user, Post $post) {
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

    public function rate(User $user, Post $post) {
        if ($post->hidden) {
            return Response::denyAsNotFound();
        }
        
        return true;
    }
}
