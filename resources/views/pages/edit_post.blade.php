@extends('layouts.app')

@section('header')
  @include('partials.header')
@endsection

@section('title', $post->title)

@section('content')
<body>
    <form class="post" method="POST" action="{{ route('post.edit', $post->id) }}" enctype="multipart/form-data">
      <div class="post_content">
        <div class="editable_title">
          <label>Title: </label>
          <input class="edit_title" name="title" value="{{ $post->title }}">
        </div>

        <div class="editable_body">
          <label hidden>body</label>        
          <textarea class="edit_body" name ="body" cols="150">{{ $post->body }}</textarea>
        </div>

        <div class="post_images">
          @foreach ($post->images()->get() as $img)
            <span class="font-light">{{ $img->path }}</span>
          @endforeach
        </div>

        <div class="editable_images">
          <label>Images: </label>
          <input class="edit_images" type="file" name="images[]" multiple>
        </div>

        <button class="edit_button">
          <span>add image</span>
          <img src="{{ asset('images/icons/plus.svg') }}" alt="add an embed" width="20" height="20">
        </button>

        @csrf
        @method('post')
        <button class="edit_button" type="submit">Save Changes</button>
        <a href="{{ route('post', $post->id) }}" class="edit_button">Cancel</a>    
      </div>
    </form>
    <form method="POST" action="{{ route('post.delete', $post->id)}}">
        @csrf
        @method('delete')
        <button class="edit_button" type="submit">Delete</button>
    </form>
</body>
@endsection