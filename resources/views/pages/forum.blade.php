@extends ('layouts.app')

@section('title', $forum->name)

@php($paginator_own = $forum->posts()->visible()->paginate(10))


@section('content')
<div class="d-flex container m-3 px-0">

    <div class="d-flex flex-column gap-3 mt-5">
        <section style="background-color: #eee;">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="container rounded bg-white p-4" style="height: min-content">
                        <div class="card-body text-center d-flex flex-column align-items-center" style="width: min-content">
                            <div class="mt-3 mb-4 d-flex flex-column align-items-center position-relative" style="height: 16vh; width: auto">
                                <img src=" {{ $forum->getBannerPictureUrl() }}" alt="{{ $forum->name . '\'s banner picture' }}" class="img-fluid" style="width: 100%; height: 75%; object-fit: cover;">
                                <img src=" {{ $forum->getForumPictureOrDefaultUrl() }}" alt="{{ $forum->name . '\'s picture' }}" class="rounded-circle img-fluid position-absolute" style="border: solid white 2px; width: 100px; top: 27%;">
                            </div>
                            <h4 class="mb-2"> {{ $forum->name }} </h4>

                            @auth
                            @if($forumOwners->contains('owner_id', Auth::user()->id))
                            <a href="{{ route('forum.management', ['forum'=>$forum->id]) }}" type="button" class="btn btn-primary d-flex gap-2">
                                Manage Forum
                            </a>
                            @elseif($forum->followers()->where('owner_id', Auth::user()->id)->first())
                            <button class="btn btn-primary d-flex gap-2" data-wt-action="forum.unfollow" data-wt-forum-id="{{ $forum->id }}">
                                <span>Unfollow</span>
                            </button>
                            @else
                            <button class="btn btn-primary d-flex gap-2" data-wt-action="forum.follow" data-wt-forum-id="{{ $forum->id }}">
                                <i class="bi bi-person-add"></i>
                                <span>Follow</span>
                            </button>
                            @endif
                            @endauth
                            <div class="d-flex justify-content-between text-center mt-4 mb-2">
                                <div class="px-3">
                                    <p class="mb-2 h5"> {{ $paginator_own->total() }} </p>
                                    <p class="text-muted mb-0">Posts</p>
                                </div>
                                <div>
                                    <p class="mb-2 h5" data-wt-signal="forum.{{ $forum->id }}.followers" data-wt-value="{{ $forum->followers->count() }}">-</p>
                                    <p class="text-muted mb-0">Followers</p>
                                </div>
                            </div>
                            <p class="my-3"> {{ $forum->description }} </p>
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

    <div class="d-flex flex-column align-items-center mx-4">
        <!-- Tabs navs -->
        <ul class="nav nav-tabs nav-fill mb-3 flex justify-between" style="width: 100%;" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" data-bs-toggle="tab" href="#personal_content" role="tab" aria-controls="personal_content_tab" aria-selected="true">
                    <i class="bi bi-fire wt-icon-like"></i>
                    Hot
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" data-bs-toggle="tab" href="#interactions" role="tab" aria-controls="interactions_tab" aria-selected="false">
                    <i class="bi bi-star-fill wt-icon-like"></i>
                    Newest
                </a>
            </li>
        </ul>
        <!-- Tabs navs -->

        <!-- Tabs content -->
        <div class="tab-content" id="">
            <div class="tab-pane show active" id="personal_content" role="tabpanel" aria-labelledby="personal_content_tab">
                @if($paginator_own->items())
                @foreach($paginator_own->items() as $post)
                @include('partials.post_preview', ['on_profile'=>True])
                @endforeach
                {{ $paginator_own }}
                @else
                <p class="text-center">
                    It is really empty in here...
                    <i class="bi bi-heartbreak-fill wt-icon-like"></i>
                </p>
                @endif
            </div>

        </div>
        <!-- Tabs content -->
    </div>
</div>
@endsection