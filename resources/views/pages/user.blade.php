@extends('layouts.app')
@section('title', $user->username)

@php($paginator = $user->posts()->visible()->paginate(10))

@section('content')
    <div class="d-flex container m-3 px-0">

        <section class="vh-100" style="background-color: #eee;">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center h-100">
                    <div class="container rounded bg-white p-4" style="height: min-content">
                        <div class="card-body text-center" style="width: min-content">
                            <div class="mt-3 mb-4 d-flex flex-column align-items-center" style="height: 16vh">
                                <img src=" {{ $user->banner_picture }}" alt="{{ $user->username . '\'s banner picture' }}" 
                                class="img-fluid" style="width: 100%; height: 75%; object-fit: cover;">
                                <img src=" {{ $user->profile_picture_or_default_url() }}" alt="{{ $user->username . '\'s banner picture' }}"
                                class="rounded-circle img-fluid position-absolute" style="border: solid white 2px; width: 100px; top: 27%;">
                            </div>
                            <h4 class="mb-2"> {{ $user->first_name . ' ' . $user->last_name }} </h4>
                            <p class="text-muted mb-4"> {{ '@' . $user->username }} <span class="mx-2"></span> </p>

                            @if($user->id == Auth::user()->id)
                                <button type="button" class="btn btn-primary">
                                    Edit Profile
                                </button>
                            @else 
                                <button type="button" class="btn btn-primary">
                                    Follow
                                </button>
                            @endif
                            <div class="d-flex justify-content-between text-center mt-4 mb-2">
                                <div>
                                <p class="mb-2 h5"> {{ $user->reputation }} </p>
                                <p class="text-muted mb-0">Reputation Points</p>
                                </div>
                                <div class="px-3">
                                <p class="mb-2 h5"> {{ $paginator->total() }} </p>
                                <p class="text-muted mb-0">Posts</p>
                                </div>
                                <div>
                                <p class="mb-2 h5"> xx </p>
                                <p class="text-muted mb-0">Followers</p>
                                </div>
                            </div>
                            <p class="my-3"> {{ $user->bio }} </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="d-flex flex-column align-items-center">
            @foreach($paginator->items() as $post)
                @include('partials.post_preview', ['on_profile'=>True])
            @endforeach
            {{ $paginator }}
        </div>
    </div>
@endsection