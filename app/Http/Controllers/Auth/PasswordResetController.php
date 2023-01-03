<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\ResetsPasswords;

class PasswordResetController extends Controller
{   
    use ResetsPasswords;
    
    /**
     * Redirect user to this URL after resetting password
     */
    protected $redirectTo = '/';

    /**
     * Create a new password reset controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * Show form for user to request a password reset link
     *
     * @return \Illuminate\View\View
     */
    public function showSendLinkForm() {
        return view('auth.passwords.forgetPassword');
    }

    /**
     * Send password reset link to the given email
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendLink(Request $request) {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with(['status' => __($status)]);
        } else {
            return back()->withErrors(['email' => __($status)]);
        }
    }

    /**
     * Show form for user to reset password
     *
     * @return \Illuminate\View\View
     */
    public function showResetPasswordForm() {
        return view('auth.passwords.resetPassword');
    }
 
}