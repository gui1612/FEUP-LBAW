@if(!$preview)
    <h2> {{ $post->title }} </h2>
    <p> {{ $post->body }} </p>
@else
    <a class="text-reset text-decoration-none" href="{{ route('post', ['preview'=>False, 'id' => $post->id]) }}">
        <h2> {{ $post->title }} </h2>
    </a>
    <p> {{ Str::limit($post->body, 250) }} </p>
@endif
