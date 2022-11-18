<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    public function show_team() {
        return view('pages.admin.team', [
            'paginator' => User::where('is_admin', true)->orderBy('id')->paginate(20)
        ]);
    }

    public function delete_from_team($id) {
        $user = User::find($id);
        if (!$user->is_admin) {
            session()->flash('error', 'User is not in team');
            return redirect()->back();
        }

        if (!Gate::allows('demote', $user)) {
            session()->flash('error', 'You are not allowed to remove this user from the administrative team');
            return redirect()->back();
        }
        
        $user->is_admin = false;
        $user->save();
        return redirect()->route('admin.team');
    }
}
