@extends('layouts.app')
@section('title', $user->username)

@php($paginator_own = $user->posts()->visible()->paginate(10))
@php($paginator_int_posts = $user->rated_posts()->visible()->paginate(10))
@php($paginator_comments = $user->comments()->visible()->paginate(10))

@section('content')
<div class="d-flex container m-3 px-0">

    <div class="d-flex flex-column gap-3 mt-5">
        <section style="background-color: #eee;">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="container rounded bg-white p-4" style="height: min-content">
                        <div class="card-body text-center d-flex flex-column align-items-center" style="width: min-content">
                            <div class="mt-3 mb-4 d-flex flex-column align-items-center position-relative" style="height: 16vh; width: 100%">
                                <img src=" {{ $user->banner_picture_url() }}" alt="{{ $user->username . '\'s banner picture' }}" class="img-fluid" style="width: 100%; height: 75%; object-fit: cover;">
                                <img src=" {{ $user->profile_picture_or_default_url() }}" alt="{{ $user->username . '\'s banner picture' }}" class="rounded-circle img-fluid position-absolute" style="border: solid white 2px; width: 100px; top: 27%;">
                            </div>
                            <h4 class="mb-2"> {{ $user->username }} </h4>
                            <p class="text-muted mb-4"> {{ '@' . $user->username }} <span class="mx-2"></span> </p>

                            @auth
                            @if($user->id == Auth::user()->id)
                            <a href="{{ route('user.edit', ['user'=>$user]) }}" class="btn btn-primary">
                                Edit Profile
                            </a>
                            @elseif($user->followers()->where('owner_id', Auth::user()->id)->first())
                            <button class="btn btn-primary d-flex gap-2" data-wt-action="user.unfollow" data-wt-user-id="{{ $user->id }}">
                                <i class="bi bi-person-check-fill"></i>
                                <span>Unfollow</span>
                            </button>
                            @else
                            <button class="btn btn-primary d-flex gap-2" data-wt-action="user.follow" data-wt-user-id="{{ $user->id }}">
                                <i class="bi bi-person-add"></i>
                                <span>Follow</span>
                            </button>
                            @endif
                            @endauth
                            <div class="d-flex justify-content-between text-center mt-4 mb-2">
                                <div>
                                    <p class="mb-2 h5"> {{ $user->reputation }} </p>
                                    <p class="text-muted mb-0">Reputation Points</p>
                                </div>
                                <div class="px-3">
                                    <p class="mb-2 h5"> {{ $paginator_own->total() }} </p>
                                    <p class="text-muted mb-0">Posts</p>
                                </div>
                                <div>
                                    <p class="mb-2 h5" data-wt-signal="user.{{ $user->id }}.followers" data-wt-value="{{ $user->followers->count() }}">-</p>
                                    <p class="text-muted mb-0">Followers</p>
                                </div>
                            </div>
                            <p class="my-3"> {{ $user->bio }} </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section style="background-color: #eee;">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="container rounded bg-white p-4" style="height: min-content">
                        <div class="card-body text-center" style="width: min-content">
                            <h4 class="mb-2">Forums</h4>
                            <div class="d-flex justify-content-between text-start mt-4 mb-2">
                                <ul class="list-unstyled">
                                    <li>Forum 1</li>
                                    <li>Forum 2</li>
                                    <li>Forum 3</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="d-flex flex-column align-items-center mx-4 w-100">
        <!-- Tabs navs -->
        <ul class="nav nav-tabs nav-fill mb-3 flex justify-between" style="width: 100%;" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" data-bs-toggle="tab" href="#personal_content" role="tab" aria-controls="personal_content_tab" aria-selected="true">
                    Personal Content
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" data-bs-toggle="tab" href="#interactions" role="tab" aria-controls="interactions_tab" aria-selected="false">
                    Interactions
                </a>
            </li>
        </ul>
        <!-- Tabs navs -->

        <!-- Tabs content -->
        <div class="tab-content w-100 d-flex flex-column">
            <div class="tab-pane show active" id="personal_content" role="tabpanel" aria-labelledby="personal_content_tab">
                <button class="dropdown-toggle btn d-flex gap-2 align-items-center bg-white ms-auto mb-3" data-bs-toggle="dropdown" aria-expanded="false">Sort By</button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('feed.show', [ 'order' => 'chronological' ]) }}">Chronological</a></li>
                    <li><a class="dropdown-item" href="{{ route('feed.show', [ 'order' => 'popularity' ]) }}">Popularity</a></li>
                </ul>
                @foreach($paginator_own->items() as $post)
                @include('partials.post_preview', ['on_profile'=>True])
                @endforeach
                {{ $paginator_own }}
            </div>
            <div class="tab-pane" id="interactions" role="tabpanel" aria-labelledby="interactions_tab">
                <button class="dropdown-toggle btn d-flex gap-2 align-items-center bg-white ms-auto mb-3" data-bs-toggle="dropdown" aria-expanded="false">Sort By</button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('feed.show', [ 'order' => 'chronological' ]) }}">Chronological</a></li>
                    <li><a class="dropdown-item" href="{{ route('feed.show', [ 'order' => 'popularity' ]) }}">Popularity</a></li>
                </ul>
                @foreach($paginator_int_posts->items() as $post)
                @include('partials.post_preview', ['post' => $post, 'on_profile'=>false, 'clickable'=>true])
                @endforeach
                {{ $paginator_int_posts }}
            </div>
        </div>
        <!-- Tabs content -->
    </div>
</div>
@endsection