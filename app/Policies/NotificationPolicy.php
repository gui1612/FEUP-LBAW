<?php

namespace App\Policies;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class NotificationPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Notification $notification) {
        return true;
    }

    public function update(User $user, Notification $notification) {
        return true;
    }
}
