<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;



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


  public function update(Request $request, int $id): RedirectResponse
  {
      $user = User::find($id);

      $validator = Validator::make($request->all(), [
          'username' => 'string|regex:/^[a-zA-Z0-9._]+$/|max:255|unique:users',
          'banner_picture' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:4096', // max 5MB
          'profile_picture' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:4096', // max 5MB
          'bio' => 'nullable|string|max:500',
      ]);
      
      if (isset($request->username)) $user->username = $request->username;
      if (isset($request->bio)) $user->bio = $request->bio;
      if (isset($request->banner_picture)) {
          $newBanner = $request->banner_picture;
          $oldBanner = $user->banner_picture;
          $imgName = round(microtime(true)*1000) . '.' . $newBanner->extension();
          $newBanner->storeAs('public/banners', $imgName);
          $user->banner_picture = $imgName;
          if (!is_null($oldBanner))
              Storage::delete('public/thumbnails/' . $oldBanner);
      }

      if (isset($request->profile_picture)) {
        $newProfile = $request->profile_picture;
        $oldProfile = $user->profile_picture;
        $imgName = round(microtime(true)*1000) . '.' . $newProfile->extension();
        $newProfile->storeAs('public/profile', $imgName);
        $user->banner_picture = $imgName;
        if (!is_null($oldProfile))
            Storage::delete('public/thumbnails/' . $oldProfile);
      }
      $user->save();
      
      return redirect("/users/${id}/edit");
    }
}    