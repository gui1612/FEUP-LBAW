@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="d-flex justify-content-center align-items-center mt-5">
    <form method="POST" action="{{ route('login.submit') }}">
        @csrf
        <fieldset class="bg-white px-5 py-4 mb-2 rounded-2">
            <legend class="text-center mb-3">Login</legend>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1" name="email" placeholder="name@example.com" value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
              </div>
              <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">Password</label>
                  <input type="password" class="form-control  @error('password') is-invalid @enderror" id="exampleInputPassword1" name="password" placeholder="Password" value="{{ old('password') }}" required>
                  @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                  @enderror
              </div>
              <button type="submit" class="btn btn-primary mt-3 mb-2">Submit</button>
              <a class="d-block" href="">Forgot your password?</a>
        </fieldset>
        <div class="bg-white p-3 rounded-2 text-center">
            <p class="mb-0">Don't have an account? <a href="{{ route('register.show') }}">Create one</a></p>    
        </div>
    </form>
</div>
@endsection
