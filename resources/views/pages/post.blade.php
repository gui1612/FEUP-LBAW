@extends('layouts.app')

@section('title', $post->title)
@php($images = $post->images()->get())

@section('content')
    <article class="container w-75 my-4 bg-white px-4 py-3 mx-auto">
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
                
            @include('partials.user_info', ['user' => $post->owner, 'clickable'=>True])

            <button class="btn d-flex align-items-center gap-2 bg-white m-4" style="width: min-content" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-three-dots-vertical"></i>
            <span class="visually-hidden">Options</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a href="{{ route('post.edit', ['id'=>$id]) }}" class="dropdown-item">Edit</a>
                </li>
                <!-- Button trigger modal -->
                <li><button type="button" class="btn btn-primary dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">Delete</a></li>
            </ul>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this post?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <form method="POST" action="{{ route('post.delete', $post->id)}}">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger" type="submit">Yes</button>
                        </form>

                </div>
                </div>
            </div>
            </div>


            </div>
        
        @include('partials.post_content')

        <span class="my-2"> on {{ date_format($post->created_at, 'Y-m-d') }}</span>
        
        @include('partials.rating')
    </article>
    
@endsection