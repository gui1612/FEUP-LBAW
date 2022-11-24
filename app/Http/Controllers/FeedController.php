<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class FeedController extends Controller
{

    /**
     * Shows the card for a given id.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Request $request) {
      $validated = $request->validate([
        'order' => 'in:popularity,chronological'
      ]);

      $order = $validated['order'] ?? 'popularity';
      if ($order === 'chronological')
        $posts = Post::orderBy('created_at', 'desc');
      else 
        $posts = Post::orderBy('rating', 'desc');

      return view('pages.feed', ['paginator' => $posts->paginate(30)]);
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
