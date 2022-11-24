@extends('layouts.app')

@section('content')

<div class="d-flex flex-column bg-white container m-3 px-0">
    <form method="POST" action="{{ route('user.edit', ['id'=>$user->id]) }}" enctype="multipart/form-data">
        @method('PATCH')
        @csrf
        <div id="user-info" class="position-relative" style="margin-bottom: clamp(1.5rem, 5vw, 4rem);">

            <div class="position-absolute bottom-0 end-0  rounded-start bg-white text-dark">
                <label role="button" for="banner_picture" class="form-label ms-3 me-3">Add Cover Picture
                    <input type="file" id="banner_picture" name="banner_picture" hidden>
                </label>
            </div>

            <div id="banner_picture">
                <img src="{{ $user->banner_picture }}" alt="{{ $user->username }}'s banner picture" width="100" height="500" class="w-100" style="height: clamp(12.5rem, 25vw, 20rem); object-fit: cover">
            </div>

            <div id="profile_picture" class="ratio ratio-1x1 border border-3 rounded-circle border-white position-absolute bottom-0" style="left: 50%; width: clamp(7.5rem, 15vw, 12.5rem); transform: translate(-250%, 50%)">
                
                <img src="{{ $user->profile_picture }}" alt="{{ $user->username }}'s profile picture" width="30" height="30" class="rounded-circle position-absolute">
                
                <div class= "position-relative">
                    <div class="position-absolute bottom-0 end-0" style="z-index: 10;">
                        <label role="button" for="profile_picture1" class="form-label ms-2 me-1"> <i class="bi bi-plus-circle-fill fa-7x" style="font-size:3rem "></i>
                            <input type="file" id="profile_picture1" name="profile_picture" hidden>
                        </label>
                    </div>
                
                </div>
            </div>

        </div>    
        
        <div class="d-flex align-items-start flex-column p-5">

            <div class="form-group p-2 bd-highlight">
                <label for="username">Username:</label>
                <input type="text" class="form-control w-75" name="username" id="username" value="{{ $user->username }}"> 
            </div>  

            <div class="form-group p-2 bd-highlight w-100">
                <label for="bio">Bio:</label>
                <textarea id="bio" type="text" class="form-control w-100" name="bio"> {{ $user->bio }} </textarea>
        
            </div>

        </div>
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary mt-3 mb-2">Update profile</button>
        </div>
    </form>
</div>

@endsection