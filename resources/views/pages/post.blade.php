@extends('layouts.app')

@section('title', $post->title)
@php($images = $post->images()->get())

@section('content')
    <article class="container w-75 m-4 bg-white px-4 py-3">
        @if($images->isNotEmpty())
            <div id="carouselExampleControls" class="carousel slide d-flex justify-content-center bg-black mx-auto w-100" style="height:30rem;" data-bs-ride="carousel" data-bs-interval="9999999">
                <div class="carousel-inner">
                    @php($img = $images[0])
                    <div class="carousel-item active h-100 bg-black">
                        <img src="{{ $img->path }}" alt= "{{ $img->caption }}" class="d-block mx-auto h-100 w-100" style="object-fit: contain;">
                        <div class="carousel-caption d-none d-md-block bg-white text-black start-0 end-0 bottom-0 px-2 py-1 text-start" style="--bs-bg-opacity: 0.85">
                            <span> {{ $img->caption }} </span>
                        </div>
                    </div>
                    @for ($i = 1; $i < $images->count(); $i++)
                    @php($img = $images[$i])
                    <div class="carousel-item h-100 bg-black">
                        <img src= "{{ $img->path }}" alt= "{{ $img->caption }}" class="d-block mx-auto h-100 w-100" style="object-fit: contain;">
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


        <div class="d-flex align-items-center justify-content-between pe-2">
                
            @include('partials.user_info')

            <a href="{{ route('post.edit', ['id'=>$id]) }}" class="text-reset btn-lg btn"> 
                <i class="bi bi-pencil"></i>
            </a>
        </div>
        

        @include('partials.post_content')

        <span class="my-2"> {{ $post->created_at }} </span>
        
        @include('partials.rating')
    </article>
@endsection