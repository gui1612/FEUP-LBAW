@extends('layouts.app')

@section('title', "Create Forum")

@section('content')

<div class="d-flex flex-column justify-content-center bg-white container m-3 px-0">
  <div id="forum-info" class="position-relative" style="margin-bottom: clamp(1.5rem, 5vw, 4rem);">
    <div id="banner-picture" class="bg-primary" style="min-height: 12.5rem;">
      @if($forum->getBannerPictureUrl())
      <img src="{{ $forum->getBannerPictureUrl() }}" alt="{{ $forum->name }}'s banner picture" width="100" height="500" class="w-100" style="height: clamp(12.5rem, 25vw, 20rem); object-fit: cover">
      @endif
    </div>
    <div id="forum-picture" class="ratio ratio-1x1 border border-3 rounded-circle border-white position-absolute bottom-0" style="left: 50%; width: clamp(7.5rem, 15vw, 12.5rem); transform: translate(-50%, 50%)">
      <img src="{{ $forum->getForumPictureOrDefaultUrl() }}" alt="{{ $forum->name }}'s profile picture" width="30" height="30" class="rounded-circle position-absolute">
    </div>
  </div>
  <form method="POST" enctype="multipart/form-data" action="{{ route('forum.create_forum') }}" class="align-self-center px-5 gap-2">
    @csrf
    <label for="username-input" class="form-label pt-4">Forum:</label>
    <div class="input-group">
      <input id="forum-input" type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" value="{{ old('name') ?? $forum->name }}" aria-label="Name" aria-describedby="basic-addon1">
      @error('name')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
      @enderror
    </div>

    <div class="align-items-start">
      <div class="form-group pt-4 bd-highlight">
        <label for="exampleFormControlTextarea1" class="form-label">Description:</label>
        <textarea id="description-text-area" name="description" class="form-control w-100 @error('description') is-invalid @enderror" id="exampleFormControlTextarea1" rows="3" columns="20">{{ old('description') ?? $forum->description }}</textarea>
        @error('description')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>
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

    <div id="edit-forum-picture">
      <label for="forumInput" class="form-label pt-4">Forum Picture:</label>
      <input id="forumInput" class="form-control @error('forum_picture') is-invalid @enderror" accept="image/*" type="file" name="forum_picture">
      @error('forum_picture')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
      @enderror
    </div>
    <button type="submit" class="btn btn-primary mt-5 mb-3 mx-5 px-5 ">Create Forum</button>
  </form>
  @endsection