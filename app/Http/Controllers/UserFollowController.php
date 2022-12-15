<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserFollowController extends Controller {

    public function __construct() {
        $this->middleware('accept:application/json');
        $this->middleware('auth')->except('show');
    }

    public function show(Request $request, User $user) {
        return response()->json([
            'followers' => $user->followers->count(),
        ]);
    }
    
    public function follow(Request $request, User $user) {
        $this->authorize('follow', $user);

        $user_id = Auth::id();

        return Follow::create([
                'owner_id' => $user_id,
                'followed_user_id' => $user->id,
                'followed_forum_id' => null,
            ]);
    }
    
    public function unfollow(Follow $follow, User $user) {
        $this->authorize('follow', $user);

        $user_id = Auth::id();
        $follow = $user->followers->where('owner_id', $user_id)->toQuery()->limit(1);
        $follow->delete();
        
        return response()->json([
            'followers' => $user->followers->count(),
        ]);
    }
}
