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

  public function show_post(Forum $forum, Post $post)
  {
    $this->authorize('view', $post);
    $paginator = $post->comments()->visible()->orderBy('last_edited', 'desc')->paginate(10);
    return view('pages.post', ['post' => $post, 'preview' => False, 'paginator'=>$paginator]);
  }

  public function show_edit_post_form(Forum $forum, Post $post)
  {
    $this->authorize('edit', $post);
    return view('pages.edit_post', ['post' => $post, 'new_post' => false]);
  }

  public function create_post(Request $request, Forum $forum)
  {
    $this->authorize('create', Post::class);

    $data = $request->validate([
      'title' => 'required|string|max:255',
      'body' => 'required|string',
      'images.*.caption' => 'nullable|required_with:images.*.file|string',
      'images.*.file' => 'nullable|image|max:4096',
      ], [
      'images.*.caption.required_with' => 'A caption is required for every image.'
    ]);


    if (!isset($data['images'])) {
      $data['images'] = [];
    }

    $data['images'] = array_filter($data['images'], function ($image) {
      return $image['caption'] != null && isset($image['file']) && $image['file'] != null;
    });

    if (count($data['images']) > 0) {
      $this->authorize('create', PostImage::class);
    }

    $post = new Post();
    $post->title = $data['title'];
    $post->body = $data['body'];
    $post->forum()->associate($forum);
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

    return redirect()->route('post', ['forum' => $forum, 'post' => $post]);
  }

  public function edit_post(Request $request, Forum $forum, Post $post)
  {
    $this->authorize('edit', $post);

    $validated = $request->validate([
      'title' => 'string|max:255',
      'body' => 'string',
    ]);

    $post->title = $validated['title'] ?? $post->title;
    $post->body = $validated['body'] ?? $post->body;
    $post->save();

    return redirect()->route('post', ['post' => $post, 'forum'=>$forum]);
  }

  public function delete_post(Request $request, Forum $forum, Post $post)
  {
    $this->authorize('delete_post', $post);

    if (Post::destroy($post->id) > 0) {
      return redirect()->route('forum.show', ['forum' => $forum]);
    } else {
      return abort(500, 'Failed to delete post.');
    }
  }
}
