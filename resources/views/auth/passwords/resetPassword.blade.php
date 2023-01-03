@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center mt-5">
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <fieldset class="bg-white px-5 py-4 mb-2">
            <legend class="text-center mb-3">Forgot Password</legend>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control  @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required>
                @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="pasword" class="form-label">Confirm Password</label>
                <input type="password" class="form-control"  id="password-confirm" name="password_confirmation" placeholder="Confirm Password" required>
            </div>

            <input type="hidden" name="token" value="{{ request()->token }}">
            <input type="hidden" name="email" value="{{ request()->email }}">

            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary mt-3 mb-2">Reset Password</button>
            </div>
        </fieldset>
    </form>
</div>
@endsection