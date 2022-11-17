@extends('layouts.app')

@section('header')
  @include('partials.header')
@endsection

@section('title', $post->title)

@section('content')
<body>
    <article class="post">
        <section class="post_content"> 
            <div class="post_content_utils">
                <a class="post_content_creator_details" href=""> 
                    <img src="{{ $post->owner()->first()->profile_picture ?? asset('images/default.png') }}" alt="{{ $post->owner()->first()->username }}" width="20" height="20" class="rounded-full m-4">
                    {{ $post->owner()->first()->username }} 
                </a>
                <a href="{{ route('post.edit', ['id'=>$id]) }}"> 
                    <img src= {{ asset('images/icons/edit.svg') }} alt="Edit post" height="20" width="20">
                </a>
            </div>

            <h2> {{ $post->title }} </h2>
            <p> {{ $post->body }} </p>

            <div class="flex gap-3">
                @foreach ($post->images()->get() as $img)
                    <div class="w-1/3 h-full aspect-square flex items-center">
                        <img src= "{{ $img->path }}" alt= "{{ $img->caption }}" class="h-full w-full object-contain">
                    </div>
                @endforeach
            </div>

            <span> {{ $post->createdAt }} </span>
            
            <div class="post_content_rating">
                <button> 
                    <img src= {{ asset('images/icons/like.svg') }} alt="Like this post" height="20" width="20">
                </button>
                {{ $post->rating }} 
                <button> 
                    <img src= {{ asset('images/icons/dislike.svg') }} alt="Dislike this post" height="20" width="20">
                </button>
            </div>
        </section>
    </article>
</body>
@endsection