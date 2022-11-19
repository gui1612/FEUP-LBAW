<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller {
    public function show($id) {
        $post = Post::find($id);

        return view('pages.post', ['post' => $post, 'id' => $id]);
    }

    public function edit($id) {
      $post = Post::find($id);

      return view('pages.edit_post', ['post' => $post, 'id' => $id]);
    }

    public function create_post() {
      return view('pages.create_post');
    }

    public function list() {
      $this->authorize('list', Card::class);
      $posts = Post::all()->orderBy('rating')->get();
      return view('pages.posts', ['posts' => $posts]);
    }

    public function create(Request $request) {
      $post = new Post();

      $this->authorize('create', $post);

      $post->title = $request->input('title');
      $post->body = $request->input('body');
      $post->owner_id = Auth::user()->id;
      $post->save();

      return $post;
    }

    public function delete(Request $request, $id) {
      $post = Post::find($id);

      $this->authorize('delete', $post);

      $post->delete();

      return $post;
    }

    public function edit_with_new_data(Request $request, $id) {
      $post = Post::find($id);

      $this->authorize('edit', $post);

      print_r($request->files);
      print_r($request->body);
      $post->title = $request->input('title');
      $post->body = $request->input('body');

      // foreach ($request->files as $file) {
      //   print_r($file);

      // }
      $post->save();

      return $post;
    }
}
