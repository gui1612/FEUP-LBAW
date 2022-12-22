@extends('layouts.app')

@section('title', $forum->name)

@php($paginator_own = $forum->posts()->visible()->paginate(10))


@section('content')

<div class="d-flex flex-column gap-3 mt-5">
  <section style="background-color: #eee;">
    <div class="container">
      <div class="row d-flex justify-content-center">
        <div class="container rounded bg-white p-4" style="height: min-content">
          <div class="card-body text-center d-flex flex-column align-items-center" style="width: min-content">
            <div class="mt-3 mb-4 d-flex flex-column align-items-center position-relative" style="height: 16vh; width: auto">
              <img src=" {{ $forum->banner_picture_url() }}" alt="{{ $forum->name . '\'s banner picture' }}" class="img-fluid" style="width: 100%; height: 75%; object-fit: cover;">
              <img src=" {{ $forum->forum_picture_or_default_url() }}" alt="{{ $forum->name . '\'s picture' }}" class="rounded-circle img-fluid position-absolute" style="border: solid white 2px; width: 100px; top: 27%;">
            </div>
            <h4 class="mb-2"> {{ $forum->name }} </h4>

            @auth

            @if($forumOwners->contains('owner_id', Auth::user()->id))
            <a href="{{ route('forum.management', ['forum'=>$forum->id]) }}" type="button" class="btn btn-primary d-flex gap-2">
              Manage Forum
            </a>
            @else
            <form method="POST" action="{{ route('follow', $forum->id) }}">
              @csrf
              @method('POST')
              <button type="button" class="btn btn-primary d-flex gap-2">
                <i class="bi bi-person-add"></i>Follow
              </button>
            </form>
            @endif

            @endauth
            <div class="d-flex justify-content-between text-center mt-4 mb-2">
              <div class="px-3">
                <p class="mb-2 h5"> {{ $paginator_own->total() }} </p>
                <p class="text-muted mb-0">Posts</p>
              </div>
              <div>
                <p class="mb-2 h5" data-wt-signal="forum.{{ $forum->id }}.followers" data-wt-value="{{ $forum->followers->count() }}">-</p>
                <p class="text-muted mb-0">Followers</p>
              </div>
            </div>
            <p class="my-3"> {{ $forum->description }} </p>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<section class="container-fluid">
  <div class="table-responsive">
    <table class="table table-hover caption-top">
      <caption>Administrators</caption>
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col" class="d-none d-md-table-cell">Name</th>
          <th scope="col">Username</th>
          <th scope="col">Email</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($paginator_own->items() as $forum)
        <tr>
          <th scope="row">{{ $forum->id }}</th>
          <td class="d-none d-md-table-cell">{{ $forum->name }}</td>

          <td>{{ $forum->description }}</td>
          <td>{{ $forum->id }}</td>
          <td>
            <form method="POST" action="{{ route('admin.team.demote', $forum->id) }}">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger d-flex gap-2"><i class="bi bi-arrow-down-circle"></i>Demote User</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  {{ $paginator_own}}
</section>
@endsection