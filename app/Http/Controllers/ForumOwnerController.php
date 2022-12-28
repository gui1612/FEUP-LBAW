<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use App\Models\Follow;
use App\Models\Forum;
use App\Models\ForumOwners;
use Illuminate\Http\Request;



class ForumOwnerController extends Controller
{

  public function show_forum_management(Forum $forum)
  {
    $owners = ForumOwners::where('forum_id', $forum->id)->with('owners')->orderBy('owner_id')->paginate(20);
    $followers = Follow::where('followed_forum_id', $forum->id)->with('owner')->orderBy('owner_id')->paginate(20);

    return view('pages.forum_management', ['forum' => $forum, 'paginator' => $owners, 'followers' => $followers]);
  }


  public function promote(Request $request)
  {
    $validated = $request->validate([
      'id' => 'required|exists:App\Models\User,id',
      'forum_id' => 'required|exists:App\Models\Forum,id'
    ]);

    $user = User::find($validated['id']);
    $forum = Forum::find($validated['forum_id']);
    $this->authorize('promote', $user);

    $forumOwners = ForumOwners::create([
      'owner_id' => $user->id,
      'forum_id' => $forum->id,
    ]);

    $forum->refresh();

    return [
      'followers' => $forum->followers->count(),
      'current' => $forumOwners,
    ];
  }

  public function demote(Request $request)
  {
    $validated = $request->validate([
      'id' => 'required|exists:App\Models\User,id',
      'forum_id' => 'required|exists:App\Models\Forum,id'
    ]);

    $user = User::find($validated['id']);
    $forum = Forum::find($validated['forum_id']);
    $this->authorize('demote', $user);

    ForumOwners::where('owner_id', $user->id)
      ->where('forum_id', $forum->id)
      ->delete();

    $forum->refresh();

    return [
      'followers' => $forum->followers->count(),
    ];
  }
}
