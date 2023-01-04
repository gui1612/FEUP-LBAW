<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use App\Utils\Toasts;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PostPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability) {
        if ($user->is_deleted()) {
            return false;
        }
    }

    public function create(User $user) {
        return true;
    }

    public function view(?User $user, Post $post) {
        if ($user?->is_admin) {
            return true;
        }

        if ($post->hidden && $user?->id !== $post->owner_id) {
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

    public function delete_post(User $user, Post $post, bool $force = false) {
        if ($post->hidden) {
            if ($user->is_admin) {
                return true;
            }

            if ($user->id === $post->owner_id) {
                return Response::denyWithStatus(403, 'You cannot delete a hidden post.');
            }

            return Response::denyAsNotFound();
        }
        
        if (!$force) {
            if ($post->ratings->count() > 0) {
                return Response::denyWithStatus(403, 'You cannot delete a post that has ratings.');
            }
            
            if ($post->comments->count() > 0) {
                return Response::denyWithStatus(403, 'You cannot delete a post that has comments.');
            }
        }

        if ($user->is_admin || $post->forum->owners->contains($user)) {
            return true;
        }
        
        if ($post->owner_id !== $user->id) {
            return Response::denyWithStatus(403, 'You are not the owner of this post.');
        }
        
        return true;
    }

    public function try_delete_post(User $user, Post $post) {
        return $this->delete_post($user, $post, true);
    }

    public function rate(User $user, Post $post) {
        if ($post->hidden) {
            return Response::denyAsNotFound();
        }
        
        return true;
    }
    
    public function report(User $user, Post $post) {
        if ($post->hidden) {
            return Response::denyAsNotFound();
        }
        
        if ($post->owner_id === $user->id) {
            return Response::denyWithStatus(403, 'You cannot report your own post.');
        }
        
        return true;
    }
}
