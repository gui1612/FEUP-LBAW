<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostCommentsController extends Controller {

    public function create_comment(Request $request, Post $post) {
        $this->authorize('view', $post);
        $this->authorize('create', Comment::class);

        $data = $request->validate([
            'body' => 'required|string',
        ]);

        $comment = new Comment();
        $comment->body = $data['body'];
        $comment->owner()->associate(Auth::user());
        $comment->post()->associate($post);
        
        $this->authorize('update', $comment);
        $comment->save();

        return redirect()->route('post', ['post' => $post]);
    }

    public function edit_comment(Request $request, Post $post, Comment $comment) {
        $this->authorize('view', $post);
        $this->authorize('update', $comment);

        $data = $request->validate([
            'body' => 'required|string',
        ]);

        $comment->body = $data['body'];
        $comment->save();

        return redirect()->route('post', ['post' => $post]);
    }

    public function delete_comment(Post $post, Comment $comment) {
        $this->authorize('view', $post);
        $this->authorize('delete', $comment);

        $comment->hidden = true;
        $comment->save();

        return redirect()->route('post', ['post' => $post]);
    }
}