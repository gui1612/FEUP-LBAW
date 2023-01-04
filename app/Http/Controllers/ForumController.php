<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


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

    $forum->followers()->attach(Auth::user());

    $forum->owners()->attach(Auth::user());

    return redirect()->route('forum.show', ['forum' => $forum]);
  }

  public function update(Request $request, Forum $forum)
  {
    $this->authorize('edit', $forum);

    $data = $request->validate([
      'name' => 'required|string|max:255',
      'description' => 'required|string',
      'forum_picture' => 'sometimes|image|max:4096',
      'banner_picture' => 'sometimes|image|max:4096',
    ]);

    if (isset($data['name'])) $forum->name = $data['name'];
    if (isset($data['description'])) $forum->description = $data['description'];

    if (isset($data['forum_picture'])) {
      $forum_picture = $request->file('forum_picture');
      $path = $forum_picture->store('images/forums', 'public');

      if (isset($forum->forum_picture)) {
        if (!str_starts_with($forum->forum_picture, 'http') && !Storage::delete($forum->forum_picture)) {
          Storage::delete($path);
          return abort(500);
        }
      }

      $forum->forum_picture = $path;
    }

    if (isset($data['banner_picture'])) {
      $banner_picture = $request->file('banner_picture');
      $path = $banner_picture->store('images/forums/banners', 'public');

      if (isset($forum->banner_picture)) {
        if (!str_starts_with($forum->banner_picture, 'http') && !Storage::delete($forum->banner_picture)) {
          Storage::delete($path);
          return abort(500);
        }
      }

      $forum->banner_picture = $path;
    }

    $forum->save();

    return redirect()->route('forum.show', ['forum' => $forum]);
  }

  public function delete(Forum $forum)
  {
    $this->authorize('delete', $forum);

    Forum::destroy($forum->id);

    return redirect()->route('feed.show')->with('success', 'Forum deleted successfully');
  }
}
