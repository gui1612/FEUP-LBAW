<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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

    public function promote(Request $request) {
        $validated = $request->validate([
            'id' => 'required|exists:App\Models\User,id'
        ]);

        $user = User::find($validated['id']);

        $this->authorize('promote', $user);

        $user->is_admin = true;
        $user->save();
        
        return redirect()->back();
    }

    public function demote(Admin $admin) {
        $this->authorize('demote', $admin);

        // if (!Gate::allows('isAdmin', $user)) {
        //     session()->flash('danger', [
        //         'title' => 'Insufficient Permissions',
        //         'message' => 'You must be an administrator to perform this action.'
        //     ]);

        //     return redirect()->back();
        // }
        
        $admin->is_admin = false;
        $admin->save();
        
        return redirect()->back();
    }

    public function show_reports() {
        $reports = Report::where('archived', false)->orderBy('created_at')->paginate(20);
        return view('pages.admin.reports', ['paginator'=>$reports]);
    }

    public function show_report(Report $report) {
        return view('pages.admin.report', ['report'=>$report]);
    }
}
