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

  public function promote(User $user, ForumOwners $target)
  {
    if ($target->contains('owner_id', $user->id)) {
      return false;
    }
    return true;
  }

  public function demote(User $user, ForumOwners $target)
  {
    return true;
  }

  public function view(User $user, User $target)
  {
    return true;
  }
}
