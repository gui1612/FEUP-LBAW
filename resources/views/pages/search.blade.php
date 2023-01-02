@extends('layouts.app')

@section('title', 'Search results for ' . $query)

@section('content')
<div class="d-flex container m-3 px-0">
    <div class="d-flex flex-column align-items-center mx-4 w-100">
        <div class="my-4 me-auto">
            @include('partials.searchbar')
        </div>

        <!-- Tabs navs -->
        <ul class="nav nav-tabs nav-fill mb-3 flex justify-between" style="width: 100%;" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" data-bs-toggle="tab" href="#users_tab" role="tab" aria-controls="users_tab" aria-selected="true">
                    Users    
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" data-bs-toggle="tab" href="#forums_tab" role="tab" aria-controls="forums_tab" aria-selected="false">
                    Forums    
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" data-bs-toggle="tab" href="#posts_tab" role="tab" aria-controls="posts_tab" aria-selected="false">
                    Posts
                </a>
            </li>
        </ul>
        <!-- Tabs navs -->
        
        <!-- Tabs content -->
        <div class="tab-content w-100">
            <div class="tab-pane show active" id="users_tab" role="tabpanel" aria-labelledby="users_tab">
                @if($users->count() == 0)
                    <p class="text-center"><strong>No users found</strong></p>
                @else
                    @foreach($users->items() as $user)
                        @include('partials.user_preview', ['user'=>$user])
                    @endforeach
                    {{ $users }}
                @endif
            </div>
            <div class="tab-pane" id="forums_tab" role="tabpanel" aria-labelledby="forums_tab">
                @if($forums->count() == 0)
                    <p class="text-center"><strong>No forums found</strong></p>
                @else
                    @foreach($forums->items() as $forum)
                        @include('partials.forum_preview', ['forum'=>$forum])
                    @endforeach
                    {{ $forums }}
                @endif
            </div>
            <div class="tab-pane" id="posts_tab" role="tabpanel" aria-labelledby="posts_tab">
                @if($posts->count() == 0)
                    <p class="text-center"><strong>No posts found</strong></p>
                @else
                    @foreach($posts->items() as $post)
                        @include('partials.post_preview', ['post' => $post, 'on_profile' => false])
                    @endforeach
                    {{ $posts }}
                @endif
            </div>
        </div>
        <!-- Tabs content -->
    </div>
</div>
@endsection