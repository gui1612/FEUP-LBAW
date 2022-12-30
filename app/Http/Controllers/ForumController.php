<?php

namespace App\Http\Controllers;

use App\Models\ForumOwners;
use App\Models\Forum;
use Illuminate\Support\Facades\Auth;
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

    //$this->authorize('view', $forum);
    $forumOwners = ForumOwners::where('forum_id', $forum->id)->get();

    return view('pages.forum', ['forum' => $forum, 'forumOwners' => $forumOwners]);
  }

  public function show_create_forum_form()
  {
    $this->authorize('create', Forum::class);

    $forum = new Forum();
    return view('pages.create_forum', ['forum' => $forum]);
  }
  /*
  public function create_forum(Request $request)
  {
    $this->authorize('create', Forum::class);

    $data = $request->validate([
      'name' => 'required|string|max:255',
      'description' => 'required|string',
      'profile_images.*.file' => 'required|image|max:4096',
      'banner_images.*.file' => 'required|image|max:4096',
    ]);

    if (!isset($data['profile_images'])) {
      $data['profile_images'] = [];
    }

    if (!isset($data['banner_images'])) {
      $data['banner_images'] = [];
    }

    if (count($data['profile_images']) > 0) {
      $this->authorize('create_profile_image', ForumProfileImage::class);
    }

    if (count($data['banner_images']) > 0) {
      $this->authorize('create_banner_image', ForumBannerImage::class);
    }

    $forum = new Forum();
    $forum->name = $data['name'];
    $forum->description = $data['description'];
    //tenso $forum->owners()->attach(Auth::user());

    $profile_images = [];
    foreach ($data['profile_images'] as $profile_image) {
      $path = $profile_image['file']->store('images/forums/profile', 'public');

      $forum_profile_image = new ForumProfileImage();
      $forum_profile_image->path = $path;

      $profile_images[] = $forum_profile_image;
    }

    DB::transaction(function () use ($forum, $images) {
      $post->save();
      foreach ($images as $image) {
        $image->post()->associate($post);
        $image->save();
      }
    });

    return redirect()->route('post', ['post' => $post]);
  }
*/

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
