@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
<body>
  <div class="container w-75 m-4 bg-white px-4 py-3 d-flex flex-column gap-2 justify-content-center">
    <h3>Edit Post</h3>
    <form class="col-md-11 mx-auto" method="POST" action="{{ route('post.edit_with_new_data', $post->id) }}" enctype="multipart/form-data">
        @csrf
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
    <code>{{ $post->images }}</code>

    @forelse($post->images as $img)
      @include('partials.post_image', ['image' => $img])
    @endforeach

    <form class="col-md-11 mx-auto" method="POST" action="{{ route('post.edit_with_new_data', $post->id) }}" enctype="multipart/form-data">
      @csrf
      @method('POST')
      <div class="mb-3">
        <label for="caption" class="form-label">Add caption</label>
        <input type="text" name="caption" id="caption" class="form-control" requeired>

        <label for="image" class="form-label mt-4">Add Image</label>
        <input type="file" name="image" id="image" class="form-control" accept="image/*">
      </div>
      <button type="submit" class="btn btn-primary mb-4">Upload Image</button>
    </form>
    <div class="col-md-11 mx-auto">
        <a href="{{ route('post', $post->id) }}" class="btn btn-secondary mb-2 ">Cancel</a>    
    </div>
  </div>
</body>
@endsection
<!-- <body>
  <div class="container w-75 m-4 bg-white px-4 py-3 d-flex flex-column gap-2 justify-content-center">
    <form class="post" method="POST" action="{{ route('post.edit', $post->id) }}" enctype="multipart/form-data">
      <div class="form-group">
        <div class="editable_title">
          <label>Title: </label>
          <input class="form-control mb-2" name="title" value="{{ $post->title }}">
      </div>

        <div class="form-group">
          <label hidden></label>        
          <textarea class="form-control mb-2" name ="body" col150">{{ $post->body }}</textarea>
        </div>

        <div class="form-group">
          @foreach ($post->images()->get() as $img)
            <span class="font-light">{{ $img->path }}</span>
          @endforeach
        </div>

        <div class="form-group">
          <label>Images: </label>
          <input class="form-control-file mb-2" type="file" name="images[]" multiple>
        </div>

        <div class="form-group">
            <button class="btn btn-primary mb-2">
            <span>add image</span>
            <img src="{{ asset('images/icons/plus.svg') }}" alt="add an embed" width="20" height="20">
            </button>
        </div>

        @csrf
        @method('post')
        <div class="form-row">
            <button class="btn btn-primary mb-2" type="submit">Save Changes</button>

            <a href="{{ route('post', $post->id) }}" class="btn btn-primary mb-2">Cancel</a>    
        </div>
      </div>
    </form>
    <form method="POST" action="{{ route('post.delete', $post->id)}}">
        @csrf
        @method('delete')
        <button class="btn btn-primary mb-2" type="submit">Delete</button>
    </form>
  </div>
</body> -->