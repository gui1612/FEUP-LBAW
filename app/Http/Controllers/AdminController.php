<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function __construct() {
        $this->middleware('admin');
    }

    public function show_users() {
        $users = User::active()->orderBy('id')->paginate(20);
        return view('pages.admin.users', ['paginator' => $users]);
    }

    public function show_team() {
        $admins = Admin::active()->orderBy('id')->paginate(20);
        return view('pages.admin.team', [
            'paginator' => $admins
        ]);
    }

    public function promote(Request $request, User $user) {
        $this->authorize('promote', $user);

        $user->is_admin = true;
        $user->save();
        
        return redirect()->back();
    }



    public function demote(Admin $admin) {
        $this->authorize('demote', $admin);
        
        $admin->is_admin = false;
        $admin->save();
        
        return redirect()->back();
    }

}
