@extends('layouts.app')

@section('header')
  @include('partials.header')
@endsection

@section('content')

<body>
    <form class="post" method="POST" action="{{ route('post.create') }}" enctype="multipart/form-data">
      <div class="post_content">
        <div class="editable_title">
          <label>Title: </label>
          <input class="edit_title" name="title">
        </div>

        <div class="editable_body">
          <label hidden>body</label>        
          <textarea class="edit_body" name ="body" cols="150"></textarea>
        </div>

        <div class="editable_images">
          <label>Images: </label>
          <input class="edit_images" type="file" name="images[]" multiple>
        </div>

        <button class="edit_button">
          <span>add image</span>
          <img src="{{ asset('images/icons/plus.svg') }}" alt="add an embed" width="20" height="20">
        </button>
      </div>
    </form>
</body>
@endsection