<?php

namespace App\Http\Controllers;

use App\Models\User;


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
    
    if (!Gate::allows('update-user', $user)) {
      abort(403);
    }

    Validator::make($request->all(), [
      'username' => 'required|string|regex:/^[a-zA-Z0-9._]+$/|  
                           max:255|unique:users',
      'bio' => 'nullable|string|max:500',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|string|min:6|confirmed', 
      'bannerPicture' => 'nullable|file|image',
      'profilePicture' => 'nullable|file|image',
    ])->validate();

    $user->username = $request->input('username');
    $user->email = $request->email;
    $user->bio = $request->bio;
    if(!is_null($request->password)) $user->password = bcrypt($request->password);
    
    if($request->hasFile('bannerPicture')) {
      $file = $request->bannerPicture;
      $filename = $user->id.'_'.time().'_'.Str::random(12).'.'.$file->getClientOriginalExtension();
      $request->bannerPicture->storeAs('users',$filename,'profile_upload');
      $user->bannerPicture = $filename;
    }

    if($request->hasFile('profilePicture')) {
      $file = $request->profilePicture;
      $filename = $user->id.'_'.time().'_'.Str::random(12).'.'.$file->getClientOriginalExtension();
      $request->profilePicture->storeAs('users',$filename,'profile_upload');
      $user->profilePicture = $filename;
    }

    $user->save();

    return redirect()->route('pages.edit_user', [
      'user' => $user->id,
    ]);
  }
}