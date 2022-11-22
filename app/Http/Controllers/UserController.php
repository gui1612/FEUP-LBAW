<?php

namespace App\Http\Controllers;

use App\Models\User;


class UserController extends Controller
{

  public function show($id) {
    return view('pages.user', ['user' => User::find($id)]);
  }
  
  public function edit($id) {
    $user = User::find($id);

    return view('pages.edit_user', ['user' => $user, 'id' => $id]);
  }
}