@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="d-flex justify-content-center align-items-center mt-5">
    <form method="POST" action="{{ route('register.submit') }}">
        @csrf
        <fieldset class="bg-white px-5 py-4 mb-2">
            <legend class="text-center mb-3">Register</legend>
            <div class="row mb-3">
              <div class="col">
                <label for="exampleInputFirstName1" class="form-label">First name</label>
                <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="exampleInputFirstName1" name="first_name" placeholder="John" value="{{ old('first_name') }}" required>
                @error('first_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
              </div>
              <div class="col">
                <label for="exampleInputLastName1" class="form-label">Last name</label>
                <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="exampleInputLastName1" name="last_name" placeholder="Doe" value="{{ old('last_name') }}" required>
                @error('last_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
              </div>
            </div>

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
              <div class="mb-3">
                <label for="exampleInputConfirmPassword1" class="form-label">Confirm password</label>
                <input type="password" class="form-control  @error('password_confirmation') is-invalid @enderror" id="exampleInputConfirmPassword1" name="password_confirmation" placeholder="Password" value="{{ old('password_confirmation') }}" required>
                @error('password_confirmation')
                  <div class="invalid-feedback">
                      {{ $message }}
                  </div>
                @enderror
            </div>
              <button type="submit" class="btn btn-primary mt-3 mb-2">Submit</button>
        </fieldset>
        <div class="bg-white p-3 text-center">
            <p class="mb-0">Already have an account? <a href="{{ route('login.show') }}">Sign in</a></p>    
        </div>
    </form>
</div>
@endsection
