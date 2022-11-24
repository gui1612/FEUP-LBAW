<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;



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
    //$this->authorize('update', $user);
    $request->validate([
        'username' => 'string|regex:/^[a-zA-Z0-9._]+$/|max:255|unique:users',
        'bio' => 'nullable|max:500',
        'banner_picture' => 'nullable|image|mimes:jpeg,jpg,png,bmp,tiff,gif|max:4096',
        'profile_picture' => 'nullable|image|mimes:jpeg,jpg,png,bmp,tiff,gif|max:4096',
    ]);

    if(isset($request->username)) $user->username = $request->username;
    if(isset($request->bio)) $user->bio = $request->bio;

    if($request->hasFile('banner_picture')) {
      $file = $request->banner_picture;
      $filename = $user->id.'_'.time().'_'.Str::random(10).'.'.$file->getClientOriginalExtension();
      $user->banner_picture = $filename;
    }

    if($request->hasFile('profile_picture')) {
      $file = $request->profile_picture;
      $filename = $user->id.'_'.time().'_'.Str::random(10).'.'.$file->getClientOriginalExtension();
      $user->profile_picture = $filename;
    }

    $user->save();
    return redirect()->route('user.edit', $user->id);    
  }
}    