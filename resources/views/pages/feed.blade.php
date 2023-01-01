@extends('layouts.app')

@section('content')

<body>
    <div class="d-flex flex-column align-items-end">
        <button class="dropdown-toggle btn d-flex align-items-center gap-2 bg-white my-4 ms-auto" style="width: min-content" data-bs-toggle="dropdown" aria-expanded="false">Sort By</button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="{{ route('feed.show', [ 'order' => 'chronological' ]) }}">Chronological</a></li>
            <li><a class="dropdown-item" href="{{ route('feed.show', [ 'order' => 'popularity' ]) }}">Popularity</a></li>
        </ul>

        {{-- @each('partials.post.preview', $paginator->items(), 'post') --}}
        @foreach($paginator->items() as $post)
        @include('partials.post_preview', ['post'=>$post, 'preview'=>True, 'on_profile'=>False, 'user'=>$post->owner, 'forum'=>$post->forum_id])
        @endforeach
        {{ $paginator }}
    </div>
</body>
@endsection