@extends('layouts.app')

@section('title', 'Homepage')

@section('content')
<div class="d-flex container m-3 px-0">
    <div class="d-flex flex-column align-items-center mx-4 w-100">
        <div class="w-100 d-flex flex-column flex-sm-row align-items-center justify-content-between">
            @include('partials.searchbar')
            <button class="dropdown-toggle btn d-flex align-items-center gap-2 bg-white m-4" style="width: min-content" data-bs-toggle="dropdown" aria-expanded="false">Sort By</button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('feed.show', [ 'order' => 'chronological' ]) }}">Chronological</a></li>
                <li><a class="dropdown-item" href="{{ route('feed.show', [ 'order' => 'popularity' ]) }}">Popularity</a></li>
            </ul>   
        </div>

        <div class="w-100 mx-2 mx-md-0">
            @foreach($paginator->items() as $post)
                @include('partials.post_preview', ['post'=>$post, 'preview'=>True, 'on_profile'=>False, 'user'=>$post->owner, 'forum'=>$post->forum_id])
            @endforeach
            {{ $paginator }}

            @if(!$paginator->hasMorePages())
                <em class="text-center d-block">That's it! You have no more posts in your feed. Follow other users or forums to fill it up.</em>
            @endif
        </div>
    </div>
</div>
@endsection