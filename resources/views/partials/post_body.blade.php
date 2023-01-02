@if(!$preview)
    <p>
        <x-markdown class="text-break">
            {{ $post->body }} 
        </x-markdown>
    </p>
@else
    <p> 
        <x-markdown class="text-break">
            {{ Str::limit($post->body, 250) }} </p>
        </x-markdown>
@endif
