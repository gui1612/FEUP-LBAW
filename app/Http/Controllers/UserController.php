<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;




class UserController extends Controller
{

  public function show($id) 
  {
    return view('pages.user', ['user' => User::find($id)]);
  }
  
  public function showEditForm($id) 
  {
    $user = User::find($id);

    return view('pages.edit_user', ['user' => $user, 'id' => $id]);
  }

  public function update(Request $request, $id) 
  {     
    $user = User::find($id);
    $this->authorize('update', $user);
    $request->validate([
        'username' => 'required|string|regex:/^[a-zA-Z0-9._]+$/|max:255|unique:users',
        'bio' => 'nullable|max:500',
    ]);
    $user->username = $request->input('username');
    $user->bio = $request->input('bio');     
        

    $user->save();
    if (Auth::user()->id == $id)
        return redirect("/users/$user->id"); 
    else
        return redirect("/admin/users");
  }
}  