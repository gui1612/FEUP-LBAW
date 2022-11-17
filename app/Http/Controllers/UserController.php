<?php

namespace App\Http\Controllers;

use App\Models\User;


class UserController extends Controller
{

  public function list() {
    $users = User::all();
    return view('pages.users', ['users' => implode(" ", compact('users'))]);
  }
}