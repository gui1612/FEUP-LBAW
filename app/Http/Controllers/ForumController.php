<?php

namespace App\Http\Controllers;

use App\Models\ForumOwners;
use App\Models\Forum;
use App\Models\User;
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
    $this->authorize('view', $forum);
    $forumOwners = $forum->owners;

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
      'forum_picture' => 'sometimes|image|max:4096',
      'banner_picture' => 'sometimes|image|max:4096',
    ]);

    $forum = new Forum();

    if (isset($data['name'])) $forum->name = $data['name'];
    if (isset($data['description'])) $forum->description = $data['description'];

    if (isset($data['banner_picture'])) {
      $banner_picture = $request->file('banner_picture');
      $path = $banner_picture->store('images/forums/banners', 'public');
      $forum->banner_picture = $path;
    }

    if (isset($data['forum_picture'])) {
      $forum_picture = $request->file('forum_picture');
      $path = $forum_picture->store('images/forums', 'public');
      $forum->forum_picture = $path;
    }

    $forum->save();

    $forum->owners()->attach(Auth::user());

    return redirect()->route('forum.show', ['forum' => $forum]);
  }
}
