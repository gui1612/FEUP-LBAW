@php($type = $post->ratings->where('owner_id', Auth::id())->first()?->type)

<div class="d-flex align-items-center gap-2 mt-2">
    <button class="btn btn-lg p-0 border-0" data-wt-action="ratings.like" data-wt-post-id="{{ $post->id }}">
        @if($type === 'like')
            <i class="bi bi-hand-thumbs-up-fill wt-icon-like"></i>
        @else
            <i class="bi bi-hand-thumbs-up wt-icon-like"></i>
        @endif
        <span class="visually-hidden">Like</span>
    </button>
    <span class="text-center" style="min-width: 4ch;">{{ $post->rating }}</span> 
    <button class="btn btn-lg p-0 border-0" data-wt-action="ratings.dislike" data-wt-post-id="{{ $post->id }}">
        @if($type === 'dislike')
            <i class="bi bi-hand-thumbs-down-fill wt-icon-dislike"></i>
        @else
            <i class="bi bi-hand-thumbs-down wt-icon-dislike"></i>
        @endif
        <span class="visually-hidden">Dislike</span>
    </button>
</div>
