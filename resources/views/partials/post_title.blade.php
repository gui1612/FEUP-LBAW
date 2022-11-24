@if(!$preview)
    <h2> {{ $post->title }} </h2>
@else
    <a class="text-reset text-decoration-none wt-hoverable" href="{{ route('post', ['preview'=>False, 'post' => $post->id]) }}">
        <h2> {{ $post->title }} </h2>
    </a>
@endif
