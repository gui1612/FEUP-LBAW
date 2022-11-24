<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostImagesController extends Controller {

    public function add_image(Request $request, Post $post) {
        $this->authorize('create', PostImage::class);

        $image = $request->validate([
            'caption' => 'required|string',
            'file' => 'required|image|max:4096',
        ]);

        $path = $image['file']->store('images/posts', 'public');
      
        $post_image = new PostImage();
        $post_image->path = $path;
        $post_image->caption = $image['caption'];
        $post_image->post()->associate($post);
        $post_image->save();

        return redirect()->back();
    }

    public function remove_image(Post $post, PostImage $image) {
        if ($image->post->id != $post->id) {
            return abort(404);
        }

        $this->authorize('delete', $image);

        if (!str_starts_with($image->path, 'http') && !Storage::delete($image->path)) {
            return abort(500);
        }
        
        $image->delete();

        return redirect()->back();
    }
}
