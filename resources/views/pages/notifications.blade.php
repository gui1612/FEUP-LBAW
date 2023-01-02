@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<body>
    <div class="container">
        <h3 class="py-3">Notifications</h3>
        
        @if($paginator->total() > 0)
        @foreach($paginator->items() as $notification)
            @include('partials.notification_preview', ['notification'=>$notification])
        @endforeach
        @else
        <span>No notifications pending</span>
        @endif
        {{ $paginator }}
    </div>
</body>
@endsection