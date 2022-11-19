@extends('layouts.app')

@section('title', $post->title)
@php($images = $post->images()->get())

@section('content')
<body class="bg bg-secondary" style="--bs-bg-opacity: .15">
    <article class="post container w-75 m-4 bg-white">
        <div class="post_content_utils">
                
            @include('partials.user_info')

            <a href="{{ route('post.edit', ['id'=>$id]) }}"> 
                <img src= {{ asset('images/icons/edit.svg') }} alt="Edit post" height="20" width="20">
            </a>
        </div>

            @include('partials.post_content')

            {{-- <div class="flex gap-3">
                @foreach ($post->images()->get() as $img)
                    <div class="w-1/3 h-full aspect-square flex items-center bg-black">
                        <img src= "{{ $img->path }}" alt= "{{ $img->caption }}" class="img-fluid">
                    </div>
                @endforeach
            </div> --}}

            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @php($img = $images[0])
                    <div class="carousel-item active">
                        <img src="{{ $img->path }}" alt= "{{ $img->caption }}" class="d-block w-100">
                    </div>
                    @for ($i = 1; $i < $images->count(); $i++)
                    @php($img = $images[$i])
                    <div class="carousel-item">
                        <img src= "{{ $img->path }}" alt= "{{ $img->caption }}" class="d-block w-50">
                    </div>
                    @endfor
                    {{-- <div class="carousel-item active">
                    <img class="d-block w-100" src="..." alt="First slide">
                    </div>
                    <div class="carousel-item">
                    <img class="d-block w-100" src="..." alt="Second slide">
                    </div>
                    <div class="carousel-item">
                    <img class="d-block w-100" src="..." alt="Third slide">
                    </div> --}}
                </div>
                {{-- <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a> --}}
            </div>

            <span> {{ $post->created_at }} </span>
            
            @include('partials.rating')
    </article>
</body>
@endsection