@if($clickable)
    <a class="text-reset text-decoration-none d-flex align-items-center" href="{{ route('user.show', ['id'=>$user]) }}"> 
        <img src="{{ $post->owner()->first()->profile_picture_or_default() }}" alt="{{ $post->owner()->first()->username }}" width="30" height="30" class="rounded-circle m-3">
        {{ $post->owner()->first()->username }} 
    </a>
@else
    <div class="d-flex align-items-center" href="{{ route('user.show', ['id'=>$user]) }}"> 
        <img src="{{ $post->owner()->first()->profile_picture_or_default() }}" alt="{{ $post->owner()->first()->username }}" width="30" height="30" class="rounded-circle m-3">
        {{ $post->owner()->first()->username }} 
    </div>
@endif