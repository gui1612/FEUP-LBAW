@extends('layouts.app')

@section('content')


<div class="d-flex flex-column bg-white container m-3 px-0">
    <div id="user-info" class="position-relative" style="margin-bottom: clamp(1.5rem, 5vw, 4rem);">
        <div id="banner-picture">
            <img id="banner-picture-preview" src="{{ isset($user['banner_picture']) ? asset('storage/banners/' . $user['banner_picture']) : $user['banner_picture']  }}" 
                alt="{{ $user->username }}'s banner picture" width="100" height="500" class="w-100" style="height: clamp(12.5rem, 25vw, 20rem); object-fit: cover">
        </div>
        <div id="profile-picture" class="ratio ratio-1x1 border border-3 rounded-circle border-white position-absolute bottom-0" style="left: 50%; width: clamp(7.5rem, 15vw, 12.5rem); transform: translate(-50%, 50%)">
            <img id="profile-picture-preview" src="{{ isset($user['profile_picture']) ?  asset('storage/profile/' . $user['profile_picture']) : $user['profile_picture'] }}"
                 alt="{{ $user->username }}'s profile picture" width="30" height="30" class="rounded-circle position-absolute">
        </div>
    </div>    
    <form  name="profileForm" method="POST" action="{{ route('editProfile', ['id'=>$user->id]) }}" enctype="multipart/form-data" id="editProfileForm">
        @method('PUT')
        @csrf
        <div class="d-flex align-items-center p-4 position-relative">
            <div class="flex-column p-5 gap-2 ">
                <div class="input-group mb-3 ">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">@</span>
                    </div>
                    <input id="username-input" type="text" name="username" class="form-control" placeholder="Username"  value="{{ old('username') ? old('username') : $user['username'] }}" aria-label="Username" aria-describedby="basic-addon1">
                </div>

                <label for="formFile" class="form-label pt-4">Banner Picture:</label>
                <div id="edit-banner-picture" class="p-2">
                    <input id="bannerInput" class="form-control" accept="image/*" type="file" name="banner_picture">
                </div>

                <label for="formFile" class="form-label pt-4">Profile Picture:</label>
                <div id="edit-profile-picture" class="p-2">
                    <input id="profileInput" class="form-control" accept="image/*" type="file" name="profile_picture">
                </div>
                <div class="align-items-start">    
                    <div class="form-group pt-4 bd-highlight">
                        <label for="exampleFormControlTextarea1" class="form-label">Bio:</label>
                        <textarea id="bio-text-area"  name="bio" class="form-control w-100" id="exampleFormControlTextarea1" rows="3" columns="20">{{ old('bio') ? old('bio') : $user['bio'] }}</textarea>
                    </div>
                </div>       
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary mt-3 mb-2">Update profile</button>
        </div>    
        
    </form>
    
    
</div>

@endsection