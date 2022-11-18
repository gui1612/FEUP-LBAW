<?php

namespace App\Http\Controllers;

use App\Models\User;


class UserController extends Controller
{

  public function show($id) {
    return view('pages.user', ['user' => User::find($id)]);
  }
}