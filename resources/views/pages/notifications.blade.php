@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<body>
    <div class="container">
        <h3 class="py-3">Notifications</h3>
        
        @foreach($paginator->items() as $notification)
            @include('partials.notification_preview', ['notification'=>$notification])
        @endforeach
        {{ $paginator }}
    </div>
</body>
@endsection