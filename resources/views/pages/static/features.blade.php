@extends('layouts.app')

@section('title', 'Main Features')

@section('content')
<div class="container w-75 m-4 bg-white d-flex flex-column gap-2 justify-content-start p-5">
  <h3>Main Features</h3>
  <div class="horizontalDivider mb-3"></div>
  <div class="col-md-11 px-4">
    <div class="pb-4">
      <h4>
        Post your own thoughts
      </h4>
      <p>
        You can post anything you enjoy or want the world to know about,
        reach more people to connect interests alike.
      </p>
    </div>

    <div class="pb-4">
      <h4>
        Follow topics and people
      </h4>
      <p>
        Follow topics you find interesting or people who think alike, to
        receive updates when they post something new.
      </p>
    </div>
    
    <div>
      <h4>
        Comment and leave your mark in the world
      </h4>
      <p>
        You may like, comment and even save posts to revisit later.
        These actions will increase the Original Poster's reputation in
        the community!
      </p>
    </div>
  </div>
</div>
@endsection