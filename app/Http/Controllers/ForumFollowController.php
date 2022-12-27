<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use App\Models\Follow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumFollowController extends Controller
{
  public function __construct()
  {
    $this->middleware('accept:application/json');
    $this->middleware('auth')->except('show');
  }

  public function show(Request $request, Forum $forum)
  {
    return response()->json([
      'followers' => $forum->followers->count(),
    ]);
  }

  public function follow(Request $request, Forum $forum)
  {
    $this->authorize('follow', $forum);

    $user_id = Auth::id();

    $follow = Follow::create([
      'owner_id' => $user_id,
      'followed_user_id' => null,
      'followed_forum_id' => $forum->id,
    ]);

    $forum->refresh();

    return [
      'followers' => $forum->followers->count(),
      'current' => $follow,
    ];
  }

  public function unfollow(Follow $follow, Forum $forum)
  {
    $this->authorize('follow', $forum);

    $user_id = Auth::id();
    $follow = $forum->followers->where('owner_id', $user_id)->toQuery()->limit(1);
    $follow->delete();

    $forum->refresh();

    return [
      'followers' => $forum->followers->count(),
      'current' => null,
    ];
  }
}
