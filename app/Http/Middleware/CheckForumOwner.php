<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckForumOwner
{
    public function handle($request, Closure $next)
    {
        $forum = $request->route('forum');
        $user = Auth::user();

        if ($user->id == $forum->user_id) {
            return $next($request);
        } else {
            return response()->json([
                'error' => 'Forbidden',
            ], 403);
        }
    }
}
