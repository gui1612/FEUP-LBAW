@if(!$preview)
    <h2 class="text-break"> {{ $post->title }} </h2>
@else
    <a class="text-reset text-decoration-none wt-hoverable text-break" href="{{ route('post', ['preview'=>False, 'post' => $post->id, 'forum'=>$post->forum]) }}">
        <h2> {{ Str::limit($post->title, 100) }} </h2>
    </a>
@endif
