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
        <label for="inputPostTitle" class="form-label">Title</label>
        <input type="text" class="form-control @error('title') is-invalid @enderror" id="inputPostTitle" name="title" placeholder="Title" value="{{ old('title') }}" required>
        @error('title')
          <div class="invalid-feedback">
              {{ $message }}
          </div>
        @enderror
      </div>
      <div class="mb-3">
        <label for="inputPostBody" class="form-label">Body</label>
        <textarea rows="18" class="form-control @error('body') is-invalid @enderror" id="inputPostBody" name="body" placeholder="Share your thoughts" required>{{ old('body') }}</textarea>
        @error('body')
          <div class="invalid-feedback">
              {{ $message }}
          </div>
        @enderror
      </div>
      <div class="mb-3">
        <label for="inputPostImage" class="form-label">Image</label>
        <input type="file" class="form-control @error('images.0.file') is-invalid @enderror" id="inputPostImage" name="images[][file]" accept="image/*">
        @error('images.0.file')
          <div class="invalid-feedback">
              {{ $message }}
          </div>
        @enderror
      </div>
      <div class="mb-3">
        <label for="inputPostImageCaption" class="form-label">Image caption</label>
        <input type="text" class="form-control @error('images.0.caption') is-invalid @enderror" id="inputPostImageCaption" name="images[][caption]">
        @error('images.0.caption')
          <div class="invalid-feedback">
              {{ $message }}
          </div>
        @enderror
      </div>

      <button type="submit" class="btn btn-primary">Submit</button>
  </form>
  <div class="col-md-11 mx-auto">
      <a href="{{ url()->previous(); }}" class="btn btn-secondary mb-2 ">Cancel</a>    
  </div>
  
</div>
@endsection