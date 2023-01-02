@extends('layouts.app')

@section('title', 'Search results for ' . $query)

@section('content')
<div class="d-flex container m-3 px-0">
    <div class="d-flex flex-column align-items-center mx-4 w-100">
            <div class="d-none d-md-block d-flex flex-column me-auto my-4">
                @include('partials.searchbar')
            </div>

            <div class="d-md-none d-flex flex-column justify-content-center my-4">
                @include('partials.searchbar')
            </div>

           <!-- Tabs navs -->
            <ul class="nav nav-tabs nav-fill mb-3 flex justify-between" style="width: 100%;" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" data-bs-toggle="tab" href="#personal_content" role="tab" aria-controls="personal_content_tab" aria-selected="true">
                        Users    
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-bs-toggle="tab" href="#interactions" role="tab" aria-controls="interactions_tab" aria-selected="false">
                        Posts
                    </a>
                </li>
            </ul>
            <!-- Tabs navs -->
            
            <!-- Tabs content -->
            <div class="tab-content w-100">
                <div class="tab-pane show active" id="personal_content" role="tabpanel" aria-labelledby="personal_content_tab">
                    @if($users->count() == 0)
                        <p class="text-center"><strong>No users found</strong></p>
                    @else
                        @foreach($users->items() as $user)
                            @include('partials.user_preview', ['user'=>$user])
                        @endforeach
                        {{ $users }}
                    @endif
                </div>
                <div class="tab-pane" id="interactions" role="tabpanel" aria-labelledby="interactions_tab">
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