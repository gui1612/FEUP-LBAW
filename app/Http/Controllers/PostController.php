<?php

namespace App\Http\Controllers;

use App\Http\Resources\RatingResource;
use App\Models\Comment;
use App\Models\Forum;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\LaravelMarkdown\Markdown;

class PostController extends Controller {
  public function __construct() {
  }

  public function show_create_post_form(Forum $forum) {
    $this->authorize('create', Post::class);
    return view('pages.create_post', ['new_post' => true, 'forum' => $forum]);
  }

  public function show_post(Post $post)
  {
    $this->authorize('view', $post);
    return view('pages.post', ['post' => $post, 'preview' => False]);
  }

  public function show_edit_post_form(Post $post)
  {
    $this->authorize('edit', $post);
    return view('pages.edit_post', ['post' => $post, 'new_post' => false]);
  }

  public function create_post(Request $request)
  {
    $this->authorize('create', Post::class);

    $data = $request->validate([
    'title' => 'required|string|max:255',
    'body' => 'required|string',
    'forum' => 'required|string',
    'images.*.caption' => 'sometimes|string',
    'images.*.file' => 'sometimes|required_with:images|image|max:4096',
    ], [
    'images.*.file.required_with' => 'The :attribute field is required when images are present.'
    ]);


    if (!isset($data['images'])) {
      $data['images'] = [];
    }

    if (count($data['images']) > 0) {
      $this->authorize('create', PostImage::class);
    }

    $post = new Post();
    $post->title = $data['title'];
    $post->body = $data['body'];
    $post->forum_id = $data['forum'];
    $post->owner()->associate(Auth::user());

    $images = [];
    foreach ($data['images'] as $image) {
      $path = $image['file']->store('images/posts', 'public');

      $post_image = new PostImage();
      $post_image->path = $path;
      $post_image->caption = $image['caption'];

      $images[] = $post_image;
    }

    DB::transaction(function () use ($post, $images) {
      $post->save();
      foreach ($images as $image) {
        $image->post()->associate($post);
        $image->save();
      }
    });

    return redirect()->route('post', ['post' => $post]);
  }

  public function edit_post(Request $request, Post $post)
  {
    $this->authorize('edit', $post);

    $validated = $request->validate([
      'title' => 'string|max:255',
      'body' => 'string',
    ]);

    $post->title = $validated['title'] ?? $post->title;
    $post->body = $validated['body'] ?? $post->body;
    $post->save();

    return redirect()->route('post', ['post' => $post]);
  }

  public function delete_post(Request $request, Post $post)
  {
    $this->authorize('delete_post', $post);

    $post->hidden = True;
    $post->save();

    return redirect()->route('feed.show');
  }
}
