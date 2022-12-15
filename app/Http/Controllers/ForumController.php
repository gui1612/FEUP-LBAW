<?php

namespace App\Http\Controllers;

use App\Models\Forum;
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
    return view('pages.forum', ['forum' => $forum]);
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
