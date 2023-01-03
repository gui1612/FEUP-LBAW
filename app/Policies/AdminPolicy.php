<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AdminPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability) {
        if ($user->is_deleted() || !$user->is_admin) {
            return false;
        }
    }

    public function demote(User $user, Admin $target) {
        return true;
    }

    public function change_report_state(User $user) {
        if ($user->is_admin) {
            return true;
        }

        return Response::denyWithStatus(403, 'You have to be an admin to change the report state.',);
    }
}
