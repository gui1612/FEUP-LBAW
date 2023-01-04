@extends('layouts.app')
@section('title', $user->username)

@section('content')
<div class="d-flex flex-column flex-md-row container m-3 px-0">

    <div class="d-flex flex-column gap-3 mt-md-5 mx-auto">
        <section style="background-color: #eee;">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="container rounded bg-white p-4" style="height: min-content">
                        <div class="card-body text-center d-flex flex-column align-items-center" style="width: min-content">
                            <div class="mt-3 mb-4 d-flex flex-column align-items-center position-relative" style="height: 16vh; width: 100%">
                                <img src=" {{ $user->banner_picture_url() }}" alt="{{ $user->username . '\'s banner picture' }}" class="w-auto h-75" style="aspect-ratio: 16 / 9; object-fit: cover;">
                                <img src=" {{ $user->profile_picture_or_default_url() }}" alt="{{ $user->username . '\'s picture' }}" class="rounded-circle img-fluid position-absolute" style="border: solid white 2px; width: 100px; top: 27%;">
                            </div>
                            <h4 class="mb-2"> {{ $user->first_name . ' ' . $user->last_name }} </h4>
                            <p class="text-muted mb-4"> {{ '@' . $user->username }} <span class="mx-2"></span> </p>

                            @auth
                            @if(!$user->email == null)
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
                            @endif
                            @endauth
                            <div class="d-flex justify-content-between text-center mt-4 mb-2">
                                <div>
                                    <p class="mb-2 h5"> {{ $user->reputation }} </p>
                                    <p class="text-muted mb-0">Reputation</p>
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
                            <p class="mt-3"> {{ $user->bio }} </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @if($user->forums->count() > 0)
        <section style="background-color: #eee;">
            <div class="container mb-2 mb-md-0">
                <div class="row d-flex justify-content-center">
                    <div class="container rounded bg-white pt-4" style="height: min-content">
                        <div class="card-body" style="width: min-content">
                            <h4 class="mb-2 ms-2">Forums</h4>
                            <div class="d-flex justify-content-between text-start mt-4 mb-2">
                                <ul class="list-unstyled">
                                    @foreach ($user->owned_forums as $forum)
                                    <li class="ms-2 mb-3">
                                        <a href="{{ route('forum.show', ['forum'=>$forum]) }}" class="d-flex align-items-center gap-2 text-decoration-none wt-hoverable" style="color: var(--bs-gray-700)">
                                            <img src="{{ $forum->getForumPictureOrDefaultUrl() }}" width="35" height="35" class="rounded-circle">
                                            {{ $forum->name }}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endif
    </div>

    <div class="d-flex flex-column align-items-center mx-md-4 mt-3 mt-md-1 w-100">
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
            <button class="dropdown-toggle btn d-flex gap-2 align-items-center bg-white ms-auto mb-3" data-bs-toggle="dropdown" aria-expanded="false">Sort By</button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('user.show', [ 'user' => $user, 'order' => 'chronological' ]) }}">Chronological</a></li>
                <li><a class="dropdown-item" href="{{ route('user.show', [ 'user' => $user, 'order' => 'popularity' ]) }}">Popularity</a></li>
            </ul>
            <div class="tab-pane show active" id="personal_content" role="tabpanel" aria-labelledby="personal_content_tab">

                @if($paginator_own->total() > 0)
                @foreach($paginator_own->items() as $post)
                    @include('partials.post_preview', ['on_profile'=>True])
                @endforeach
                @else
                <div class="w-100 text-center">
                    <span>This user has no posts</span>
                </div>
                @endif

                {{ $paginator_own }}
            </div>
            <div class="tab-pane" id="interactions" role="tabpanel" aria-labelledby="interactions_tab">

                @if($paginator_int_posts->total() > 0 || $paginator_comments->total() > 0)
                @foreach($paginator_int_posts->items() as $post)
                    @include('partials.post_preview', ['post' => $post, 'on_profile'=>false, 'clickable'=>true])
                @endforeach
                @foreach($paginator_comments->items() as $comment)
                    @include('partials.comment_preview', ['comment'=>$comment])
                @endforeach
                @else
                <div class="w-100 text-center">
                    <span>This user has not interacted with any content</span>
                </div>
                @endif

                {{ $paginator_int_posts }}
                {{ $paginator_comments }}
            </div>
        </div>
    </div>
</div>
@endsection