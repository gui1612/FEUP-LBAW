@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')

<div class="d-flex justify-content-center align-items-center mt-5">
    <form method="POST" action="{{ route('sendLink') }}">
        @csrf
        <fieldset class="bg-white px-5 py-4 mb-2">
            <legend class="text-center mb-3">Forgot Password</legend>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1" name="email" placeholder="name@example.com" value="{{ old('email') }}" required>
                @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary mt-3 mb-2">Send Email</button>
            </div>
        </fieldset>

    </form>
</div>

@endsection