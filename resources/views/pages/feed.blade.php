@extends('layouts.app')

@section('header')
  @include('partials.header')
@endsection

@section('content')
<body>
    <div class="dropdown">
        <ul class="dropdown-menu dropdown-menu-lg-end">
            <li><a class="dropdown-item" href="#">Profile</a></li>
            {{-- <li><a class="dropdown-item" href="#">Another action</a></li> --}}
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Sign Out</a></li>
        </ul>   
    </div>

    @foreach($posts as $post)
        @include('partials.post_preview', ['post'=>$post, 'preview'=>True])
    @endforeach
</body>
@endsection