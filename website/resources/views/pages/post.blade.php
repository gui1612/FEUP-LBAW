@extends('layouts.app')

@section('header')
  @include('partials.header')
@endsection

@section('title', $post->title)

@section('content')
<body>
    <article class="post">
        <section> {{ $post->title }} </section>
        <section> {{ $post->body }} </section>
        <section> {{ $post->created_at }} - by - {{ $post->owner_id }} </section>
        <section> {{ $post->rating }} </section>
    </article>
</body>
@endsection