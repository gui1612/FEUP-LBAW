<?php

namespace App\Policies;

use App\Models\PostImage;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PostImagePolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->is_deleted()) {
            return false;
        }

        if ($user->is_admin) {
            return true;
        }
    }

    public function create(User $user)
    {
        return true;
    }

    public function delete(User $user, PostImage $image)
    {
        if ($image->post->hidden) {
            return Response::denyAsNotFound();
        }

        if ($user->id !== $image->post->owner_id) {
            return Response::denyWithStatus(403, 'You are not the owner of this image\'s post.');
        }

        return true;
    }
}
