<?php

namespace App\Http\Controllers;

use App\Models\ForumOwners;
use App\Models\Forum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ForumController extends Controller
{

  /**
   * Shows the card for a given id.
   *
   * @param  int  $id
   * @return Response
   */
  public function show(Forum $forum)
  {

    //$this->authorize('view', $forum);
    $forumOwners = ForumOwners::where('forum_id', $forum->id)->get();

    return view('pages.forum', ['forum' => $forum, 'forumOwners' => $forumOwners]);
  }

  public function show_create_forum_form()
  {
    $this->authorize('create', Forum::class);

    $forum = new Forum();
    return view('pages.create_forum', ['forum' => $forum]);
  }

  public function create_forum(Request $request)
  {
    $this->authorize('create', Forum::class);

    $data = $request->validate([
      'name' => 'required|string|max:255',
      'description' => 'required|string',
      'profile_images.*.file' => 'required|image|max:4096',
      'banner_images.*.file' => 'required|image|max:4096',
    ]);

    $forum = new Forum();
    $forum->name = $data['name'];
    $forum->description = $data['description'];

    if ($request->hasFile('profile_images')) {
      $forum_picture = $request->file('profile_images');
      $path = $forum_picture->store('public/forum_pictures');
      $forum->forum_picture_path = $path;
    }

    if ($request->hasFile('banner_images')) {
      $banner_picture = $request->file('banner_images');
      $path = $banner_picture->store('public/banner_pictures');
      $forum->banner_picture_path = $path;
    }

    $forum->save();



    return redirect()->route('forum.show', ['forum' => $forum]);
  }
}
