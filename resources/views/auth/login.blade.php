@extends('layouts.app')

@section('content')

<div class="container forms">
    <div class="form login">
        <div class="form-content">
            <header>Log In</header>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="field input-field">
                    <input class="username" type="text" name="username" placeholder="Username" required>
                    @if ($errors->has('username'))
                        <span class="error">
                          {{ $errors->first('username') }}
                        </span>
                    @endif
                </div>
                <div class="field input-field">
                    <input class="password" type="password" name="password" placeholder="Password" required>
                    <i class='bx bx-hide eye-icon'></i>
                    @if ($errors->has('password'))
                        <span class="error">
                            {{ $errors->first('password') }}
                        </span>
                    @endif
                </div>
                
                <div class="form-link">
                    <a class="forgot-password" href="">Forgot password?</a>
                </div> 

                <div class="field button-field">
                    <button>Login</button>
                </div>
            
                <div class="form-link">
                    <span>Don't have an account? 
                        <a class="signup-link" href="{{route('register')}}"> Signup</a>
                    </span>
                </div>
            </form>
        </div>
    </div>   
</div>
@endsection
