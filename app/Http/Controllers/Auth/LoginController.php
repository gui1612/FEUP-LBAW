<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function getUser(){
        return $request->user();
    }

    public function home() {
        return redirect('login');
    }

    public function homepage() {
        return view('pages.homepage');
    }

    public function authenticated(Request $request, $user)
    {
        if ($user->block_reason) {
            Auth::logout();
            return $this->home()->withErrors([
                'email' => "You have been blocked from using this website. Reason: " . $user->block_reason
            ]);
        }
    }

    private function sanitizeUsername($username) {
        // Replace any invalid characters with underscores
        $sanitizedUsername = preg_replace('/[^a-zA-Z0-9._]/', '_', $username);

        // Trim any leading or trailing underscores
        $sanitizedUsername = trim($sanitizedUsername, '_');

        return $sanitizedUsername;
    }

    public function splitFullName(?string $fullName): array {
        if ($fullName === NULL)
            return array(NULL, NULL);

        $nameParts = explode(' ', $fullName);
        $firstName = NULL;
        $lastName = NULL;
        if (count($nameParts) >= 1) {
            $firstName = $nameParts[0];
        }
        if (count($nameParts) >= 2) {
            $lastName = $nameParts[count($nameParts) - 1];
        }
        return [$firstName, $lastName];
    }

    public function redirectToProvider($provider) {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider) {
        try {
            $socialiteUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('login');
        }
    
        $user = User::where([
            'provider' => $provider,
            'provider_id' => $socialiteUser->getId()
        ])->first();

        if (!$user) {

            $validator = Validator::make(
                [
                    'email' => $socialiteUser->getEmail(), 
                    'username' => $socialiteUser->getNickname()],
                [
                    'email' => ['unique:users,email'], 
                    'username' => ['unique:users,username']],
                [
                    'email.unique' => 'Couldn\'t log in. Maybe you used a different login method', 
                    'username.unique' => 'Couldn\'t log in. Maybe you used a different login method'
                ]
            );

            if ($validator->fails()) {
                return redirect()->route('login')->withErrors($validator);
            }

            $userData = [
                'email' => $socialiteUser->getEmail(),
                'provider' => $provider,
                'provider_id' => $socialiteUser->getId(),
            ];

            $nameComponents = $this->splitFullName($socialiteUser->getName());
            $firstName = $nameComponents[0];
            $lastName = $nameComponents[1];

            // Set the username if it is not null
            if ($socialiteUser->getNickname() !== null) {
                $userData['username'] = $this->sanitizeUsername($socialiteUser->getNickname());
            } else {
                $emailParts = explode('@', $socialiteUser->getEmail());
                $userData['username'] = $this->sanitizeUsername($emailParts[0]);
            }

            // Set the first name if it is not null
            if ($firstName !== null) {
                $userData['first_name'] = $firstName;
            }

            // Set the last name if it is not null
            if ($lastName !== null) {
                $userData['last_name'] = $lastName;
            }

            // Set the profile picture if it is not null
            if ($socialiteUser->getAvatar() !== null) {
                $userData['profile_picture'] = $socialiteUser->getAvatar();
            }

            $user = User::create($userData);
        } else if ($user->block_reason) {
            return $this->home()->withErrors([
                'email' => "You have been blocked from using this website. Reason: " . $user->block_reason
            ]);
        }

        Auth::login($user);

        return redirect()->route('feed.show');
    }
}
