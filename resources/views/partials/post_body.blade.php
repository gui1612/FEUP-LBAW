@if(!$preview)
    <p> {{ $post->body }} </p>
@else
    <p> {{ Str::limit($post->body, 250) }} </p>
@endif
