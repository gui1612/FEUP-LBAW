@if(!$preview)
    <h2> {{ $post->title }} </h2>
@else
    <a class="text-reset text-decoration-none" href="{{ route('post', ['preview'=>False, 'id' => $post->id]) }}">
        <h2> {{ $post->title }} </h2>
    </a>
@endif

<p> {{ $post->body }} </p>