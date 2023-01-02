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

    $forum->followers()->attach(Auth::id());

    return [
      'followers' => $forum->followers->count(),
      'current' => [
        'owner_id' => Auth::id(),
        'followed_forum_id' => $forum->id,
      ],
    ];
  }

  public function unfollow(Forum $forum)
  {
    $this->authorize('unfollow', $forum);

    $forum->followers()->detach(Auth::id());

    return [
      'followers' => $forum->followers->count(),
      'current' => null,
    ];
  }
}
