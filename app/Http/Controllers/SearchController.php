<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller {

    public function search(Request $request) {
        $search = $request->input('q');

        $posts = Post::whereRaw("tsvector @@ plainto_tsquery('english', ?)", [$search])
            ->orderByRaw("ts_rank(tsvector, plainto_tsquery('english', ?)) DESC", [$search])
            ->paginate(20);


        $users = User::whereRaw("tsvector @@ plainto_tsquery('english', ?)", [$search])
            ->orderByRaw("ts_rank(tsvector, plainto_tsquery('english', ?)) DESC", [$search])
            ->paginate(20);

        return view('pages.search', ['query' => $search, 'users' => $users, 'posts' => $posts]);
    }
}
