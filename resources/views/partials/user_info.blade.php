<a class="text-reset text-decoration-none d-flex align-items-center" href="{{ route('user.show', ['user'=>$user]) }}"> 
    <img src="{{ $user->profile_picture_or_default_url() }}" alt="{{ $user->username }}" width="30" height="30" class="rounded-circle m-3">
    {{ $user->username }} 
</a>