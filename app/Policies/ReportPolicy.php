<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class ReportPolicy
{
    use HandlesAuthorization;

    public function create(User $user) {
        return true;
    }
}
