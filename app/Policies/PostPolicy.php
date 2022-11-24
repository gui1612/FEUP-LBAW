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

    public function create(User $user) {
        return true;
    }

    public function view(User $user, Post $post) {
        return !$post->hidden || $user->id === $post->owner_id;
    }
    
    public function edit(User $user, Post $post) {
        return $post->owner_id === $user->id;
    }
    
    public function delete(User $user, Post $post) {
        if ($post->ratings()->count() > 0) {
            return false;
        }
        
        return $post->owner_id === $user->id;
    }
}
