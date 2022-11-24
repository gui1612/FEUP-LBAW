<?php

namespace App\Http\Controllers;

use App\Http\Resources\RatingResource;
use App\Models\Post;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller {
    public function show($id) {
        $post = Post::find($id);

        return view('pages.post', ['post' => $post, 'id' => $id, 'preview' => False]);
    }

    public function edit($id) {
      $post = Post::find($id);

      return view('pages.edit_post', ['post' => $post, 'id' => $id, 'new_post' => false]);
    }

    public function create_post() {
      return view('pages.create_post', ['new_post' => true]);
    }

    public function list() {
      $this->authorize('list', Post::class);
      $posts = Post::all()->orderBy('rating')->get();
      return view('pages.posts', ['posts' => $posts]);
    }

    public function create(Request $request) {
      $post = new Post();

      $post->title = $request->input('title');
      $post->body = $request->input('body');
      $post->owner_id = Auth::user()->id;
      $post->save();

      return redirect()->route('post', ['id' => $post->id]);
    }

    public function delete(Request $request, $id) {
      $post = Post::find($id);
      //print_r(Auth::user());

      $this->authorize('delete', $post);

      $post->delete();

      //   return $post;
      return redirect()->route('user.profile');
    }

    public function edit_with_new_data(Request $request, $id) {
      $post = Post::find($id);

      $this->authorize('edit_post', $post);

      $post->title = $request->input('title');
      $post->body = $request->input('body');

      $post->save();

      return redirect( route('user.show', $post->owner) );
    }

  function api_get_rating($id) {
    if (!Auth::check()) {
      return response()->json([], 401);
    }

    $user_id = Auth::user()->id;
    $post = Post::find($id);
    $rating = $post->ratings()->where('owner_id', $user_id)->first();

    return [
      'type' => $rating->type,
      'rating' => $post->rating
    ];
  }

  function api_rate($id) {
    if (!Auth::check()) {
      return response()->json([], 401);
    }

    $user_id = Auth::user()->id;
    $post = Post::find($id);
    $query = $post->ratings()->where('owner_id', $user_id);
    $rating = $query->first();

    if ($rating) {
      if (is_null(request('type'))) {
        $query->delete();
        $post->refresh();

        return [
          'type' => null,
          'rating' => $post->rating
        ];
      } else {
        $rating->type = request('type');
        $query->save($rating);
      }
    } else {
      $rating = new Rating;
      $rating->type = request('type');
      $rating->owner_id = $user_id;
      $rating->rated_post_id = $id;
      $rating->save();
    }

    $post->refresh();
    
    return [
      'type' => $rating->type,
      'rating' => $post->rating
    ];
  }
}
