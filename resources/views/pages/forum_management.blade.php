@extends('layouts.forum_layout')

@section('title', $forum->name)

@php($paginator_own = $forum->posts()->visible()->paginate(10))

@section('content')
<script src="{{ asset('js/app.js') }}"></script>

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

  <form method="POST" enctype="multipart/form-data" action="{{ route('forum.update', ['forum' => $forum]) }}" class="align-self-center px-5 gap-2">
    @method('PUT')
    @csrf
    <label for="username-input" class="form-label pt-4">Forum:</label>
    <div class="input-group">
      <div class="input-group-prepend">
        <span class="input-group-text" id="basic-addon1">@</span>
      </div>
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

    <div id="edit-forum-picture">
      <label for="profileInput" class="form-label pt-4">Forum Picture:</label>
      <input id="profileInput" class="form-control @error('forum_picture') is-invalid @enderror" accept="image/*" type="file" name="forum_picture">
      @error('forum_picture')
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

    <button type="submit" class="btn btn-primary mt-5">Update Forum</button>
  </form>

  <section class="container-fluid mt-5 mx-2">
    <div class="table-responsive">
      <table class="table table-hover caption-top" style="table-layout: fixed;">
        <h4>Forum Owners</h4>
        <thead>
          <tr>
            <th scope="col" class="d-table-cell">Name</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($owners->items() as $owner)
          <tr>
            <td class="pt-3 d-table-cell">{{ '@' . $owner->username }}</td>

            <td>
              <button type="button" class="btn btn-danger d-flex gap-2 demote-button" data-bs-toggle="modal" data-bs-target="#demotionWarningModal" data-wt-action="modals.forum.demote.open" data-wt-url="{{ route('forum.management.demote', ['forum' => $forum, 'user' => $owner]) }}" data-wt-username="{{$owner->username}}">
                <i class="bi bi-arrow-down-circle"></i>
                <span class="d-none d-md-block">Demote User</span>
              </button>
              <!-- Modal -->
              <div class="modal fade" id="demotionWarningModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Demote <span data-wt-signal="modals.forum.demote.username"></span></h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      Are you sure you want to demote this user?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                      <form method="POST" data-wt-signal="modals.forum.demote.url:action">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Yes</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    {{ $owners}}
  </section>

  @if($followers->total() > 0)
  <section class="align-self-right container-fluid mt-5 my-5 mx-2">
    <div class="table-responsive">
      <table class="table table-hover caption-top " style="table-layout: fixed;">
        <h4>Users</h4>
        <thead>
          <tr>
            <th scope="col" class="d-table-cell">Name</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($followers->items() as $follower)
          <tr>
            <td class="d-table-cell">@ {{ $follower->username }}</td>

            <td>
              <button type="button" class="btn btn-secondary d-flex gap-2" data-bs-toggle="modal" data-bs-target="#promotionWarningModal" data-wt-action="modals.forum.promote.open" data-wt-url="{{ route('forum.management.promote', ['forum' => $forum, 'user' => $follower]) }}" data-wt-username="{{$follower->username}}">
                <i class="bi bi-arrow-up-circle"></i>
                <span class="d-none d-md-block">Promote Use</span>
                </button>
              <!-- Modal -->
              <div class="modal fade" id="promotionWarningModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Promote <span data-wt-signal="modals.forum.promote.username"></span></h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      Are you sure you want to promote this user?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                      <form method="POST" data-wt-signal="modals.forum.promote.url:action">
                        @csrf
                        <button class="btn btn-danger" type="submit" data-bs-toggle="modal" data-bs-target="#promotionWarningModal">Yes</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    {{ $followers }}
  </section>
  @endif

  <button type="button" class="btn btn-danger d-flex gap-2 align-self-center mb-3" data-bs-toggle="modal" data-bs-target="#deletionWarningModal" data-wt-action="modals.forum.delete.open" data-wt-forum_name="{{$forum->name}}"><i class="bi bi-trash"></i>Delete Forum</button>
  <!-- Modal -->
  <div class="modal fade" id="deletionWarningModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Delete <span data-wt-signal="modals.forum.delete.forum_name"></span></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete this forum?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
          <form method="POST" action="{{ route('forum.delete', ['forum' => $forum]) }}">
            @csrf
            @method('DELETE')
            <input type="hidden" name="hidden" value="true">
            <button class="btn btn-danger" type="submit">Yes</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection