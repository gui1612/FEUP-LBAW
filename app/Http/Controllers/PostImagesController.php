<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Http\Request;

class PostImagesController extends Controller {

    public function add_image(Request $request, Post $post) {
        $this->authorize('create', PostImage::class);

        $image = $request->validate([
            'caption' => 'required|string',
            'file' => 'required|image|dimensions:min_width:400,min_height:225,max_width=1920,max_height=1080',
        ]);

        $path = $image['file']->store('images/posts', 'public');
      
        $post_image = new PostImage();
        $post_image->path = $path;
        $post_image->caption = $image['caption'];
        $post_image->post()->associate($post);
        $post_image->save();

        return redirect()->back();
    }

    public function delete_image(Post $post, PostImage $image) {
        if ($image->post->id != $post->id) {
            abort(404);
        }

        $this->authorize('delete', $image);

        $image->delete();

        return redirect()->back();
    }
}
