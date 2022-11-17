<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function panel()
    {
        return view('pages.admin.panel', [
            'admins' => User::where('is_admin', true)->orderBy('id')->cursorPaginate(15)
        ]);
    }
}
