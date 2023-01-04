<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class FeedController extends Controller
{

    /**
     * Shows the card for a given id.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Request $request) {
      $validated = $request->validate([
        'order' => 'sometimes|in:popularity,chronological'
      ]);

      $order = $validated['order'] ?? 'popularity';

      if (Auth::check()) {
        $posts = Post::visible()->whereIn('forum_id', function($query) {
          $query->select('followed_forum_id')->from('follows')->where('owner_id', Auth::id());
        })->union(Post::visible()->whereIn('owner_id', function($query) {
          $query->select('followed_user_id')->from('follows')->where('owner_id', Auth::id());
        }));
      } else {
        $posts = Post::visible();
      }

      if ($order === 'chronological')
        $posts = $posts->orderBy('created_at', 'desc');
      else 
        $posts = $posts->orderBy('rating', 'desc');

      return view('pages.feed', ['paginator' => $posts->paginate(30)]);
    }
}
