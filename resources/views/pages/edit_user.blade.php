@extends('layouts.app')

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

    <div class="d-flex flex-column flex-md-row gap-3 align-items-start p-4 justify-content-center m-2 mt-4">
        <div class="flex-column px-5 gap-2">
            <form class="d-flex flex-column" method="POST" action="{{ route('editProfile', ['user'=>$user]) }}" enctype="multipart/form-data" id="editProfileForm">
                @method('PUT')
                @csrf
                <h3>Profile Changes</h3>
                <label for="username-input" class="form-label pt-4">Username:</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">@</span>
                    </div>
                    <input id="username-input" type="text" name="username" class="form-control @error('username') is-invalid @enderror" placeholder="Username" value="{{ old('username') ?? $user->username }}" aria-label="Username" aria-describedby="basic-addon1">
                    @error('username')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div>
                    <label for="firstaNameInput" class="form-label pt-4">First Name:</label>
                    <input id="firstNameInput" class="form-control @error('first_name') is-invalid @enderror" type="text" name="first_name" value="{{ old('first_name') ?? $user->first_name }}">
                    @error('first_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div>
                    <label for="lastNameInput" class="form-label pt-4">Last Name:</label>
                    <input id="lastNameInput" class="form-control @error('last_name') is-invalid @enderror" type="text" name="last_name" value="{{ old('last_name') ?? $user->last_name }}">
                    @error('last_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div>
                    <label for="emailInput" class="form-label pt-4">Email:</label>
                    <input id="emailInput" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') ?? $user->email }}">
                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <hr class="mt-5 mb-3">

                <div class="align-items-start">
                    <div class="form-group pt-4 bd-highlight">
                        <label for="exampleFormControlTextarea1" class="form-label">Bio:</label>
                        <textarea id="bio-text-area" name="bio" class="form-control w-100 @error('bio') is-invalid @enderror" id="exampleFormControlTextarea1" rows="3" columns="20">{{ old('bio') ?? $user->bio }}</textarea>
                        @error('bio')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div id="edit-profile-picture">
                    <label for="profileInput" class="form-label pt-4">Profile Picture:</label>
                    <input id="profileInput" class="form-control @error('profile_picture') is-invalid @enderror" accept="image/*" type="file" name="profile_picture">
                    @error('profile_picture')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div id="edit-banner-picture">
                    <label for="bannerInput" class="form-label pt-4">Banner Picture:</label>
                    <input id="bannerInput" class="form-control @error('banner_picture') is-invalid @enderror" accept="image/*" type="file" name="banner_picture">
                    @error('banner_picture')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary mt-5 me-auto">Update profile</button>
                <a href="{{ route('user.show', ['user'=>$user]) }}" class="btn btn-danger mt-2" style="width: max-content">Cancel</a>
            </form>
        </div>
        <div>
            <form method="POST" action="{{ route('editProfile', ['user'=>$user]) }}" id="changePasswordForm">
                @csrf
                @method('PUT')
                <h3>Password Reset</h3>
                <div>
                    <label for="passwordInput" class="form-label pt-4">Current Password:</label>
                    <input id="passwordInput" class="form-control @error('password') is-invalid @enderror" type="password" name="password" required>
                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div>
                    <label for="newPasswordInput" class="form-label pt-4">New password:</label>
                    <input id="newPasswordInput" class="form-control @error('new_password') is-invalid @enderror" type="password" name="new_password" required>
                    @error('new_password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div>
                    <label for="confirmPasswordInput" class="form-label pt-4">Confirm new password:</label>
                    <input id="confirmPasswordInput" class="form-control @error('new_password_confirmation') is-invalid @enderror" type="password" name="new_password_confirmation" required>
                    @error('new_password_confirmation')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary mt-5">Change Password</button>
            </form>

            <button type="button" class="btn btn-danger d-flex gap-2 mt-2" data-bs-toggle="modal" data-bs-target="#deletionWarningModal" data-wt-action="modals.admin.users.delete.open" data-wt-url="{{ route('user.delete', $user->id) }}" data-wt-username="{{$user->username}}">
                <i class="bi bi-trash3"></i>
                <span class="d-none d-md-block">Delete Account</span>
            </button>

            <!-- Modal -->
            <div class="modal fade" id="deletionWarningModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete <span data-wt-signal="modals.admin.users.delete.username"></span></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete your account?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                            <form method="POST" data-wt-signal="modals.admin.users.delete.url:action">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Yes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection