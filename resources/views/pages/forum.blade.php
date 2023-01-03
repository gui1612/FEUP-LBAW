@extends ('layouts.forum_layout')

@section('title', $forum->name)

@php($paginator_own = $forum->posts()->visible()->paginate(10))


@section('content')
<div class="d-flex flex-column flex-md-row container m-3 px-0">

    <div class="d-flex flex-column gap-3 mt-md-5 mx-auto">
        <section style="background-color: #eee;">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="container rounded bg-white p-4" style="height: min-content">
                        <div class="card-body text-center d-flex flex-column align-items-center" style="width: min-content">
                            <div class="mt-3 d-flex flex-column align-items-center position-relative" style="height: 16vh; width: auto">
                                <img src=" {{ $forum->getBannerPictureUrl() }}" alt="{{ $forum->name . '\'s banner picture' }}" class="w-auto h-75" style="aspect-ratio: 16 / 9; object-fit: cover;">
                                <img src=" {{ $forum->getForumPictureOrDefaultUrl() }}" alt="{{ $forum->name . '\'s picture' }}" class="rounded-circle img-fluid position-absolute" style="border: solid white 2px; width: 100px; top: 27%;">
                            </div>
                            <div class="d-flex align-items-center">
                                <h4 class="mb-2"> {{ $forum->name }} </h4>
                                @can('report', $forum)
                                @include('partials.report', ['content'=>'forum', 'forum'=>$forum])
                                @endcan
                            </div>
                            <div class="d-flex gap-2 flex-column justify-content-center mt-2">
                                @auth
                                    @can("edit", $forum)
                                    <a href="{{ route('forum.management', ['forum'=>$forum->id]) }}" type="button" class="btn btn-primary d-flex gap-2 mx-auto">
                                        Manage Forum
                                    </a>
                                    @elsecan("unfollow", $forum)
                                    <button class="btn btn-primary d-flex gap-2 mx-auto" data-wt-action="forum.unfollow" data-wt-forum-id="{{ $forum->id }}">
                                        <i class="bi bi-person-check-fill"></i>
                                        <span>Unfollow</span>
                                    </button>
                                    @else
                                    <button class="btn btn-primary d-flex gap-2 mx-auto" data-wt-action="forum.follow" data-wt-forum-id="{{ $forum->id }}">
                                        <i class="bi bi-person-add"></i>
                                        <span>Follow</span>
                                    </button>
                                    @endif
                                @endauth

                                <a href="{{ route('post.create', ['forum'=>$forum]) }}" class="d-flex btn btn-primary gap-2 mx-auto">
                                    <i class="bi bi-plus-square"></i>
                                    New Post
                                </a>
                            </div>
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
                            <p class="mt-3"> {{ $forum->description }} </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="d-flex flex-column align-items-center mx-md-4 mt-3 mt-md-1 w-100">
        @if($paginator_own->items())
        @foreach($paginator_own->items() as $post)
        @include('partials.post_preview', ['on_profile'=>False])
        @endforeach
        {{ $paginator_own }}
        @else
        <p class="text-center pt-5">
            It is really empty in here...
            <i class="bi bi-heartbreak-fill wt-icon-like"></i>
        </p>
        @endif
    </div>
</div>
@endsection