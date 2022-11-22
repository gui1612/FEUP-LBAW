@extends('layouts.app')

@section('content')

<div class="d-flex flex-column bg-white container m-3 px-0">
        <div id="user-info" class="position-relative" style="margin-bottom: clamp(1.5rem, 5vw, 4rem);">
            <button class="btn btn-light position-absolute rounded-0 bottom-0 end-0 border border-light">add cover photo</button>
            <div id="banner-picture">
                <img src="{{ $user->banner_picture }}" alt="{{ $user->username }}'s banner picture" width="100" height="500" class="w-100" style="height: clamp(12.5rem, 25vw, 20rem); object-fit: cover">
            </div>
            <div id="profile-picture" class="ratio ratio-1x1 border border-3 rounded-circle border-white position-absolute bottom-0" style="left: 50%; width: clamp(7.5rem, 15vw, 12.5rem); transform: translate(-250%, 50%)">
                <img src="{{ $user->profile_picture }}" alt="{{ $user->username }}'s profile picture" width="30" height="30" class="rounded-circle position-absolute">
            </div>
        </div> 

</div>

  @endsection 