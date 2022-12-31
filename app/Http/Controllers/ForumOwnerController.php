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
    $this->authorize('edit', $forum);

    $owners = $forum->owners()->orderBy('id')->paginate(20);
    $followers = $forum->followers()->orderBy('id')->paginate(20);

    return view('pages.forum_management', ['forum' => $forum, 'owners' => $owners, 'followers' => $followers]);
  }

  public function promote(Forum $forum, User $user)
  {
    $this->authorize('promote', $forum);

    $forum->owners()->attach($user);
    $forum->save();

    return redirect()->route('forum.management', ['forum' => $forum]);
  }

  public function demote(Forum $forum, User $user)
  {
    $this->authorize('demote', $forum);

    $forum->owners()->detach($user);
    $forum->save();

    return redirect()->route('forum.management', ['forum' => $forum]);
  }
}
