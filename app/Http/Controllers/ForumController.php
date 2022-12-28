<?php

namespace App\Http\Controllers;

use App\Models\ForumOwners;
use App\Models\Forum;
use App\Models\Follow;
use App\Models\User;
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
    // $forum = Forum::findOrFail($post->id);
    //$this->authorize('view', $forum);
    $forumOwners = ForumOwners::where('forum_id', $forum->id)->get();
    return view('pages.forum', ['forum' => $forum, 'forumOwners' => $forumOwners]);
  }

  public function show_forum_management(Forum $forum)
  {
    $forumOwners = ForumOwners::where('forum_id', $forum->id)->get();
    $follows = Follow::where('followed_forum_id', $forum->id)->get();
    return view('pages.manage_forum', ['forum' => $forum, 'forumOwners' => $forumOwners, 'follows' => $follows]);
  }
  /*public function show_forum(Forum $forum, Request $request) {
      $validated = $request->validate([
        'order' => 'sometimes|in:popularity,chronological'
      ]);
      

      $order = $validated['order'] ?? 'popularity';
      if ($order === 'chronological')
        $posts = $forum->posts::visible()->orderBy('created_at', 'desc');
      else 
        $posts = $forum->posts::visible()->orderBy('rating', 'desc');

      return view('pages.forum', ['paginator' => $posts->paginate(30)]);
    }*/
}
