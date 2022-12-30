@if(!$preview)
    <p>
        <x-markdown>
            {{ $post->body }} 
        </x-markdown>
    </p>
@else
    <p> 
        <x-markdown>
            {{ Str::limit($post->body, 250) }} </p>
        </x-markdown>
@endif
