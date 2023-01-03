@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
<body>
  <div class="container w-75 m-4 bg-white px-4 py-3 d-flex flex-column gap-2 justify-content-center">
    <h3>Edit Post</h3>
    <form class="col-md-11 mx-auto" method="POST" action="{{ route('post.edit_with_new_data', ['forum' => $post->forum, 'post' => $post->id]) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input class="form-control" name="title" id="title" value="{{ old('title') ?? $post->title }}" required>
        </div>
        <div class="mb-3">
            <label for="body" class="form-label">Body</label>
            <textarea rows="18" name="body" class="form-control" id="body" required>{{ old('body') ?? $post->body }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary mb-4">Save Changes</button>
      </form>

    <h4 class="col-md-11 mx-auto">Images</h4>
    @forelse($post->images as $img)
      @include('partials.post_image', ['image' => $img])
    @endforeach

    <form class="col-md-11 mx-auto" method="POST" action="{{ route('post.images.add', $post->id) }}" enctype="multipart/form-data">
      @csrf
      <div class="mb-3">
        <label for="image" class="form-label mt-4">Add Image</label>
        <input type="file" name="file" id="image" class="form-control" accept="image/*">

      </div>
      <div class="mb-3">
        <label for="caption" class="form-label">Add caption</label>
        <input type="text" name="caption" id="caption" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary mb-4">Upload Image</button>
    </form>
    <div class="col-md-11 mx-auto">
        <a href="{{ route('post', ['forum' => $post->forum, 'post' => $post->id]) }}" class="btn btn-secondary mb-2 ">Back to post</a>    
    </div>
  </div>
</body>
@endsection