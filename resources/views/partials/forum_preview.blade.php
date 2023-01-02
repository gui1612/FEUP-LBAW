<a href="{{ route('forum.show', ['forum' => $forum]) }}" class="d-flex mb-4 bg-white gap-3 p-4 text-decoration-none align-items-center rounded shadow" style="color: var(--bs-gray-700)">
    <img class="rounded-circle" src="{{ $forum->getForumPictureOrDefaultUrl() }}" alt="{{ $forum->name }} profile picture" width="50" height="50" style="height: 5rem; width: 5rem;">
    <div class="d-flex flex-column">
        <div class="my-1">
            <h4 class="mb-2">{{ $forum->name }}</h4>
        </div>
        <div>
            <span>{{ $forum->followers->count() }} followers</span> 
            <i class="d-none d-md-inline bi bi-dot"></i>
            <span class="d-none d-md-inline">{{ $forum->posts->count() }} posts</span>
        </div>
        <span class="text-dark pt-2">{{ $forum->description }}</span>
    </div>
</a>