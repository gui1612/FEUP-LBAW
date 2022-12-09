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
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        @endif
        
        @include('partials.post_title')
        @include('partials.post_body')

        <div class="d-flex gap-4">
            <span class="mb-2">By 
                <a href={{ route('user.show', $post->owner) }}>{{ $post->owner->username }}</a> 
                on {{ date_format($post->last_edited, 'Y-m-d') }}</span>
        </div>

        @include('partials.rating')

        @auth
            <form method="POST" class="d-flex gap-3 py-4" style="align-items: start"> <!-- to-do: form routing -->
                @csrf
                @method('POST')
                <img src="{{ Auth::user()->profile_picture }}" alt="Your profile picture" width="30" height="30" class="rounded-circle ratio ratio-1x1" style="width: 3rem; height: auto;">
                <label for="comment" class="visually-hidden">Comment</label>
                <textarea id="comment" placeholder="Add a comment" class="form-control"></textarea>
            </form>

            <div class="d-flex justify-content-end w-100 gap-3">
                <button type="submit" class="btn btn-primary mb-3">Submit</button>
                <button class="btn btn-danger mb-3">Cancel</button> <!-- to-do: make buttons appear on click js -->
            </div>
        @endauth

        <section class="container" id="comment-section">
            @foreach ($post->comments as $comment)
                @include('partials.comment', ['comment' => $comment])
            @endforeach
        </section>
    </article>
    
@endsection