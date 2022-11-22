@extends('layouts.app')

@section('header')
  @include('partials.header')
@endsection

@section('content')
<body>
  <div class="container w-75 m-4 bg-white px-4 py-3 d-flex flex-column gap-2 justify-content-center">
    <h3>New Post</h3>
    <form class="col-md-11 mx-auto" method="POST" action="{{ route('post.create') }}" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label visually-hidden">Title</label>
            <input class="form-control" id="title" value="{{ $post->title }}">
        </div>
        <div class="mb-3">
            <label for="body" class="form-label visually-hidden">Body</label>
            <textarea rows="18" class="form-control" id="body">{{ $post->body }}</textarea>
        </div>
        <div class="mb-3">
          <label for="images" class="form-label visually-hidden">Images</label>
          <input type="file" class="form-control-file" multiple>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
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