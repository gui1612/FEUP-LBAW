<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ForumOwners;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForumOwnersPolicy
{
  use HandlesAuthorization;

  public function before(User $user, $ability)
  {
    if ($user->is_deleted()) {
      return false;
    }
  }

  public function view(User $user, User $target)
  {
    return true;
  }
}
