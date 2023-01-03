@extends('layouts.app')

@section('title', "Create Post")

@section('content')
<div class="container w-75 m-4 bg-white px-4 py-3 d-flex flex-column gap-2 justify-content-center">
  <h3>New Post in 
    <a href="{{ route('forum.show', ['forum'=>$forum]) }}" class="wt-hoverable text-decoration-none">{{ $forum->name }}</a>
  </h3>
  <form class="col-md-11 mx-auto" method="POST" action="{{ route('post.create_post', ['forum'=>$forum]) }}" enctype="multipart/form-data">
      @csrf
      <div class="mb-3">
          <label for="title" class="form-label">Title</label>
          <input class="form-control" id="title" name="title" placeholder="Title" required>
      </div>
      <div class="mb-3">
          <label for="body" class="form-label">Body</label>
          <textarea rows="18" class="form-control" name="body" id="body" placeholder="Share your thoughts" required></textarea>
      </div>
      <div class="mb-3">
        <label for="image1" class="form-label">Image</label>
        <input type="file" id="image1" name="images[][file]" class="form-control" accept="image/*">
      </div>
      <div class="mb-3">
        <label for="caption1" class="form-label">Caption</label>
        <input type="text" id="caption1" name="images[][caption]" class="form-control">
      </div>

      <input type="hidden" id="forum" name="forum" value="{{ $forum->id }}">

      <button type="submit" class="btn btn-primary">Submit</button>
  </form>
  <div class="col-md-11 mx-auto">
      <a href="{{ url()->previous(); }}" class="btn btn-secondary mb-2 ">Cancel</a>    
  </div>
  
</div>
@endsection