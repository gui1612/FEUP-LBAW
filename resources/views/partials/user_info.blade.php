<a class="text-reset text-decoration-none d-flex align-items-center" href=""> 
    <img src="{{ $post->owner()->first()->profile_picture ?? asset('images/default.png') }}" alt="{{ $post->owner()->first()->username }}" width="30" height="30" class="rounded-circle m-3">
    {{ $post->owner()->first()->username }} 
</a>