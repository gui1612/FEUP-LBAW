<?php

namespace App\Http\Controllers;

use App\Models\User;


class UserController extends Controller {

  public function show_user(User $user) {
    $this->authorize('view', $user);
    
    return view('pages.user', ['user' => $user]);
  }
}