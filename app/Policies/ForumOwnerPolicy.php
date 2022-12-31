<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Forum;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForumOwnersPolicy
{
  use HandlesAuthorization;

  public function before(User $user)
  {
    if ($user->is_deleted()) {
      return false;
    }
  }

  public function view(Forum $forum)
  {
    return true;
  }
}
