<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class FeedController extends Controller
{
    /**
     * Shows the card for a given id.
     *
     * @param  int  $id
     * @return Response
     */
    public function show_chronological() {
      $posts = Post::orderBy('created_at')->paginate(30);
      return view('pages.feed', ['paginator' => $posts]);
    }

    public function show_rated() {
      $posts = Post::orderBy('rating')->paginate(30);
      return view('pages.feed', ['paginator' => $posts]);
    }

    /**
     * Shows all cards.
     *
     * @return Response
     */
    public function list()
    {
    //   if (!Auth::check()) return redirect('/login');
    //   $this->authorize('list', Card::class);
    //   $cards = Auth::user()->cards()->orderBy('id')->get();
    //   return view('pages.cards', ['cards' => $cards]);
    }

    /**
     * Creates a new card.
     *
     * @return Card The card created.
     */
    public function create(Request $request)
    {
    //   $card = new Card();

    //   $this->authorize('create', $card);

    //   $card->name = $request->input('name');
    //   $card->user_id = Auth::user()->id;
    //   $card->save();

    //   return $card;
    }

    public function delete(Request $request, $id)
    {
    //   $card = Card::find($id);

    //   $this->authorize('delete', $card);
    //   $card->delete();

    //   return $card;
    }
}
