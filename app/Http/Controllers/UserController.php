<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller {

  public function show_user(User $user) {
    $this->authorize('view', $user);
    
    return view('pages.user', ['user' => $user]);
  }
  
  public function showEditForm(User $user) {
    $this->authorize('edit', $user);

    return view('pages.edit_user', ['user' => $user]);
  }


  public function update(Request $request, User $user)
  {
    $this->authorize('edit', $user);

      $validated = $request->validate([
        'username' => ['sometimes', 'string', 'regex:/^[a-zA-Z0-9._]+$/', 'max:255', Rule::unique('users')->ignore($user->id)],
        'first_name' => 'sometimes|string|alpha_num|max:255',
        'last_name' => 'sometimes|string|alpha_num|max:255',
        'email' => ['sometimes', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        'banner_picture' => 'sometimes|image|max:4096', // max 4MB
        'profile_picture' => 'sometimes|image|max:4096', // max 4MB
        'bio' => 'sometimes|string|max:500',
      ]);

      if (isset($validated['username'])) $user->username = $validated['username'];
      if (isset($validated['first_name'])) $user->first_name = $validated['first_name'];
      if (isset($validated['last_name'])) $user->last_name = $validated['last_name'];
      if (isset($validated['email'])) $user->email = $validated['email'];
      if (isset($validated['bio'])) $user->bio = $validated['bio'];

      if ($request->has('new_password')) {
        $passwords = $request->validate([
          'password' => 'required|current_password',
          'new_password' => 'required|string|min:6|confirmed',
        ]);

        $user->password = bcrypt($passwords['new_password']);
      }

      if (isset($validated['profile_picture'])) {
        $profile_picture = $request->file('profile_picture');
        $path = $profile_picture->store('images/users', 'public');

        if (isset($user->profile_picture)) {
          if (!str_starts_with($user->profile_picture, 'http') && !Storage::delete($user->profile_picture)) {
            Storage::delete($path);
            return abort(500);
          }
        }

        $user->profile_picture = $path;
      }

      if (isset($validated['banner_picture'])) {
        $banner_picture = $request->file('banner_picture');
        $path = $banner_picture->store('images/users/banners', 'public');

        if (isset($user->banner_picture)) {
          if (!str_starts_with($user->banner_picture, 'http') && !Storage::delete($user->banner_picture)) {
            Storage::delete($path);
            return abort(500);
          }
        }

        $user->banner_picture = $path;
      }

      $user->save();

      return redirect()->route('user.show', ['user' => $user]);
    }
}    