<?php

namespace App\Http\Controllers;

use App\Events\UpdateNotifications;
use App\Models\Comment;
use App\Models\CommentRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CommentRatingController extends Controller {

    public function __construct() {
        $this->middleware('accept:application/json');
        $this->middleware('auth')->except('show');
    }

    public function show(Request $request, Comment $comment) {
        $user_id = Auth::id();
        $rating = $comment->ratings->where('owner_id', $user_id)->first();
        return response()->json([
            'rating' => $comment->rating,
            'current' => $rating,
        ]);
    }
    
    public function save(Request $request, Comment $comment) {
        $this->authorize('rate', $comment);

        $validated = $request->validate([
            'type' => [
                'required',
                Rule::in(['like', 'dislike'])
            ],
        ]);

        $type = $validated['type']; 

        $user_id = Auth::id();
        $rating = $comment->ratings->where('owner_id', $user_id)->first();

        if (is_null($rating)) {
            $rating = CommentRating::create([
                'owner_id' => $user_id,
                'rated_comment_id' => $comment->id,
                'type' => $type,
            ]);
        } else {
            $rating->type = $type;
            $rating->save();
        }

        $comment->refresh();

        UpdateNotifications::dispatch($comment->owner, 'new');

        return response()->json([
            'rating' => $comment->rating,
            'current' => $rating,
        ]);
    }
    
    public function destroy(Comment $comment) {
        $this->authorize('rate', $comment);

        $user_id = Auth::id();
        $ratings = $comment->ratings->where('owner_id', $user_id)->toQuery()->limit(1);
        $deleted = $ratings->delete();
        
        $comment->refresh();

        UpdateNotifications::dispatch($comment->owner, 'consistency');
        
        return response()->json([
            'rating' => $comment->rating,
            'current' => $deleted ? null : $ratings->first(),
        ]);
    }
}
