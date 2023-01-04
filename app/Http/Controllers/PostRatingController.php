<?php

namespace App\Http\Controllers;

use App\Events\UpdateNotifications;
use App\Models\Post;
use App\Models\PostRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PostRatingController extends Controller {

    public function __construct() {
        $this->middleware('accept:application/json');
        $this->middleware('auth')->except('show');
    }

    public function show(Request $request, Post $post) {
        $user_id = Auth::id();
        $rating = $post->ratings->where('owner_id', $user_id)->first();
        return response()->json([
            'rating' => $post->rating,
            'current' => $rating,
        ]);
    }
    
    public function save(Request $request, Post $post) {
        $this->authorize('rate', $post);

        $validated = $request->validate([
            'type' => [
                'required',
                Rule::in(['like', 'dislike'])
            ],
        ]);

        $type = $validated['type']; 

        $user_id = Auth::id();
        $rating = $post->ratings->where('owner_id', $user_id)->first();

        if (is_null($rating)) {
            $rating = PostRating::create([
                'owner_id' => $user_id,
                'rated_post_id' => $post->id,
                'type' => $type,
            ]);
        } else {
            $rating->type = $type;
            $rating->save();
        }

        $post->refresh();

        UpdateNotifications::dispatch($post->owner, 'new');

        return response()->json([
            'rating' => $post->rating,
            'current' => $rating,
        ]);
    }
    
    public function destroy(Post $post) {
        $this->authorize('rate', $post);

        $user_id = Auth::id();
        $ratings = $post->ratings->where('owner_id', $user_id)->toQuery()->limit(1);
        $deleted = $ratings->delete();
        
        $post->refresh();
        
        if ($deleted) {
            UpdateNotifications::dispatch($post->owner, 'consistency');
        }

        return response()->json([
            'rating' => $post->rating,
            'current' => $deleted ? null : $ratings->first(),
        ]);
    }
}
