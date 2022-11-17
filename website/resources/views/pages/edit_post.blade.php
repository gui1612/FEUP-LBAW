@extends('layouts.app')

@section('header')
  @include('partials.header')
@endsection

@section('title', $post->title)

@section('content')
<body>
    <form class="post">
      <div class="post_content">
        <div class="editable_title">
          <label>Title: </label>
          <span class="edit_title" contenteditable="true">
            {{ $post->title }}
          </span>
        </div>

        <div class="editable_body">
          <label hidden>body</label>        
          <p class="edit_body" contenteditable="true">
            {{ $post->body }}
          </p>
        </div>

        <div class="post_images">
          @foreach ($post->images()->get() as $img)
            <span class="font-light">{{ $img->path }}</span>
          @endforeach
        </div>

        <button class="edit_button">
          <span>add image</span>
          <img src= {{ asset('images/icons/plus.svg') }} alt="add an embed" width="20" height="20">
        </button>

        <button class="edit_button">Save Changes</button>
        <a href="{{ route('post', ['id'=>$id]) }}" class="edit_button">Cancel</a>
        <button class="edit_button bg-red-500" >Delete Post</button>
      </div>
    </form>
</body>
@endsection