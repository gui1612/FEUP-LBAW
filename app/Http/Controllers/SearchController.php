<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller {

    public function search(Request $request) {
        $search = $request->input('q');

        $posts = Post::whereRaw("NOT hidden AND tsvector @@ plainto_tsquery('english', ?)", [$search])
            ->orderByRaw("ts_rank(tsvector, plainto_tsquery('english', ?)) DESC", [$search])
            ->paginate(20);

        $users = User::whereRaw("tsvector @@ plainto_tsquery('english', ?)", [$search])
            ->orderByRaw("ts_rank(tsvector, plainto_tsquery('english', ?)) DESC", [$search])
            ->union(User::where('username', $search))
            ->paginate(20);

        $forums = Forum::whereRaw("NOT hidden AND tsvector @@ plainto_tsquery('english', ?)", [$search])
        ->orderByRaw("ts_rank(tsvector, plainto_tsquery('english', ?)) DESC", [$search])
        ->paginate(20);

        return view('pages.search', ['query' => $search, 'users' => $users, 'posts' => $posts, 'forums' => $forums]);
    }
}
