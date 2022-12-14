<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class ForumController extends Controller
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
      if ($order === 'chronological')
        $posts = Post::visible()->orderBy('created_at', 'desc');
      else 
        $posts = Post::visible()->orderBy('rating', 'desc');

      return view('pages.forum', ['paginator' => $posts->paginate(30)]);
    }
}
