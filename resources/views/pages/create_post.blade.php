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
            <input class="form-control" id="title" placeholder="Title">
        </div>
        <div class="mb-3">
            <label for="body" class="form-label visually-hidden">Body</label>
            <textarea rows="18" class="form-control" id="body" placeholder="Share your thoughts"></textarea>
        </div>
        <div class="mb-3">
          <label for="images" class="form-label visually-hidden">Images</label>
          <input type="file" class="form-control-file" multiple>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <div class="col-md-11 mx-auto">
        <a href="{{ url()->previous(); }}" class="btn btn-secondary mb-2 ">Cancel</a>    
    </div>
  </div>
</body>
@endsection