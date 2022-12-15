<?php

namespace App\Policies;

use App\Models\Forum;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class ForumPolicy
{
    use HandlesAuthorization;

    public function view(User? $user, Forum $forum) {
        return true;
    }
}
?>