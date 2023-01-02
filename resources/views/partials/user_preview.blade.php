<a href="{{ route('user.show', ['user' => $user]) }}" class="d-flex mb-4 bg-white gap-3 p-4 text-decoration-none align-items-center rounded shadow" style="color: var(--bs-gray-700)">
    <img class="rounded-circle" src="{{ $user->profile_picture_or_default_url() }}" alt="{{ $user->username }} profile picture" width="50" height="50" style="height: 5rem; width: 5rem;">
    <div class="d-flex flex-column">
        <div class="my-1">
            <h4 class="mb-2 d-block d-md-inline-block">{{ $user->first_name . ' ' . $user->last_name }}</h4>
            <span class="d-block d-md-inline-block">{{ '@' . $user->username }}</span>
        </div>
        <div>
            <span>{{ $user->followers->count() }} followers</span> 
            <i class="d-none d-md-inline bi bi-dot"></i>
            <span class="d-none d-md-inline">{{ $user->reputation }} reputation points</span>
        </div>
        <span class="text-dark pt-2">{{ $user->bio }}</span>
    </div>
</a>