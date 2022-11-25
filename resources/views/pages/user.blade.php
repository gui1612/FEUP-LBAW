@extends('layouts.app')
@section('title', $user->username)

@php($paginator = $user->posts->visible()->paginate(10))

@section('content')
    <div class="d-flex flex-column bg-white container m-3 px-0">
        <div id="user-info" class="position-relative" style="margin-bottom: clamp(1.5rem, 5vw, 4rem);">
            <div id="banner-picture" class="bg-primary" style="min-height: 12.5rem;">
                @if($user->banner_picture_url())
                    <img src="{{ $user->banner_picture_url() }}" alt="{{ $user->username }}'s banner picture" width="100" height="500" class="w-100" style="height: clamp(12.5rem, 25vw, 20rem); object-fit: cover">
                @endif
            </div>
            <div id="profile-picture" class="ratio ratio-1x1 border border-3 rounded-circle border-white position-absolute bottom-0" style="left: 50%; width: clamp(7.5rem, 15vw, 12.5rem); transform: translate(-50%, 50%)">
                <img src="{{ $user->profile_picture_or_default_url() }}" alt="{{ $user->username }}'s profile picture" width="30" height="30" class="rounded-circle position-absolute">
            </div>
        </div>   
        <div class="d-flex align-items-center p-4 justify-content-center position-relative">
            @can('edit', $user)    
            <div class="position-absolute top-0 end-0 translate-middle">
                <a href="{{ route('user.edit', ['user'=>$user]) }}" class="btn btn-secondary text-decoration-none text-white">
                     Edit Profile<i class='bi bi-arrow-right"'></i>
                </a>
            </div> 
            @endcan
            <div class="d-flex flex-column p-4 gap-2 align-items-center">
                <span>{{ '@' . $user->username }} <i class="bi bi-dot"></i> {{ $paginator->total() }} posts</span>
                <span> <i class="bi bi-stars"></i> {{ $user->reputation }} reputation points</span>
                <div id="user_bio">
                    <p class="d-flex text-center">{{ $user->bio }}</p>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column align-items-center">
            @foreach($paginator->items() as $post)
                @include('partials.post_preview', ['on_profile'=>True])
            @endforeach
            {{ $paginator }}
        </div>
    </div>
@endsection