<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{

    public function __construct() {
        $this->middleware('admin');
    }

    public function show_users() {
        $users = User::whereNotNull('email')->orderBy('id')->paginate(20);
        return view('pages.admin.users', ['paginator' => $users]);
    }

    public function show_team() {
        $admins = User::where('is_admin', true)->orderBy('id')->paginate(20);
        return view('pages.admin.team', [
            'paginator' => $admins
        ]);
    }

    public function promote(Request $request) {
        $validated = $request->validate([
            'id' => 'required|exists:App\Models\User,id'
        ]);

        $user = User::find($validated['id']);
        $user->is_admin = true;
        $user->save();
        
        return redirect()->route('admin.team');
    }

    public function demote(Admin $admin) {
        // FIXME
        if (!Gate::allows('isAdmin', $user)) {
            session()->flash('danger', [
                'title' => 'Insufficient Permissions',
                'message' => 'You must be an administrator to perform this action.'
            ]);

            return redirect()->back();
        }
        
        $user->is_admin = false;
        $user->save();
        return redirect()->route('admin.team');
    }
}
