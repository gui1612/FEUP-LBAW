@extends('layouts.app')

@section('title', $post->title)

@section('content')
<body>
    <article class="post">
        <section class="post_content"> 
            <div class="post_content_utils">
                
                @include('partials.user_info')

                <a href="{{ route('post.edit', ['id'=>$id]) }}"> 
                    <img src= {{ asset('images/icons/edit.svg') }} alt="Edit post" height="20" width="20">
                </a>
            </div>

            @include('partials.post_content')

            <div class="flex gap-3">
                @foreach ($post->images()->get() as $img)
                    <div class="w-1/3 h-full aspect-square flex items-center bg-black">
                        <img src= "{{ $img->path }}" alt= "{{ $img->caption }}" class="img-fluid">
                    </div>
                @endforeach
            </div>

            <span> {{ $post->created_at }} </span>
            
            @include('partials.rating')
        </section>
    </article>
</body>
@endsection