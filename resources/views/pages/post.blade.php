@extends('layouts.app')

@section('title', $post->title)
@php($images = $post->images()->get())

@section('content')
    <article class="container w-75 my-4 bg-white px-4 py-3 mx-auto">
        @if($images->isNotEmpty())
            <div id="carouselExampleControls" class="mb-3 carousel slide d-flex justify-content-center bg-black mx-auto w-100" style="height:30rem;" data-bs-ride="carousel" data-bs-interval="9999999">
                <div class="carousel-inner">
                    @php($img = $images[0])
                    <div class="carousel-item active h-100 bg-black">
                        <img src="{{ $img->url() }}" alt= "{{ $img->caption }}" class="d-block mx-auto h-100 w-100" style="object-fit: contain;">
                        <div class="carousel-caption d-none d-md-block bg-white text-black start-0 end-0 bottom-0 px-2 py-1 text-start" style="--bs-bg-opacity: 0.85">
                            <span> {{ $img->caption }} </span>
                        </div>
                    </div>
                    @for ($i = 1; $i < $images->count(); $i++)
                    @php($img = $images[$i])
                    <div class="carousel-item h-100 bg-black">
                        <img src= "{{ $img->url() }}" alt= "{{ $img->caption }}" class="d-block mx-auto h-100 w-100" style="object-fit: contain;">
                        <div class="carousel-caption d-none d-md-block bg-white text-black start-0 end-0 bottom-0 px-2 py-1 text-start" style="--bs-bg-opacity: 0.85">
                            <span> {{ $img->caption }} </span>
                        </div>
                    </div>
                    @endfor
                </div>
                @if($images->count() > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
                @endif
            </div>
        @endif
        
        <div class="d-flex align-items-center justify-content-between">
            @include('partials.post_title')
            @include('partials.post_actions')
        </div>

        @include('partials.post_body')

        <div class="d-flex gap-4">
            <div class="mb-2 d-flex flex-column flex-sm-row gap-3">
                <span>
                    By 
                    <a href="{{ route('user.show', $post->owner) }}" class="wt-hoverable text-decoration-none">{{ $post->owner->username }}</a> 
                    <i class="bi bi-dot"></i>
                    on
                    <a href="{{ route('forum.show', ['forum'=>$post->forum]) }}" class="wt-hoverable text-decoration-none">{{ $post->forum->name }}</a>
                </span>
                <span style="font-weight: 300">{{ displayDate($post->last_edited) }}</span>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2 mt-2">
            @include('partials.rating')
            @can('report', $post)
            @include('partials.report', ['content'=>'post', 'post'=>$post])
            @endcan
        </div>

        @auth
            <form method="POST" action="{{ route('post.comments.create', ['post'=>$post]) }}" class="d-flex flex-column align-items-end gap-3 pt-4" style="align-items: start"> 
                @csrf
                @method('POST')
                <div class="d-flex gap-3 pt-4 w-100">
                    <img src="{{ Auth::user()->profile_picture_or_default_url() }}" alt="Your profile picture" width="30" height="30" class="rounded-circle" style="width: 3rem; height: 3rem;">
                    <label for="body" class="visually-hidden">Comment</label>
                    <textarea id="body" name="body" placeholder="Add a comment" class="form-control"></textarea>
                </div>

                <button type="submit" class="btn btn-primary mb-3">Submit</button>
            </form>
        @endauth

        <section class="container" id="comment-section">
            @foreach ($paginator as $comment)
                @include('partials.comment', ['comment' => $comment])
            @endforeach
            {{ $paginator }}
        </section>
    </article>
    
@endsection