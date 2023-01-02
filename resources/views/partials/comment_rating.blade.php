@php($type = $comment->ratings->where('owner_id', Auth::id())->first()?->type)

<div class="d-flex align-items-center gap-2">
    <button class="btn btn-lg p-0 border-0" data-wt-action="comment.like" data-wt-comment-id="{{ $comment->id }}">
        {{-- TODO --}}
        @if($type === 'like')
            <i class="bi bi-hand-thumbs-up-fill wt-icon-like"></i>
        @else
            <i class="bi bi-hand-thumbs-up wt-icon-like"></i>
        @endif
        <span class="visually-hidden">Like</span>
    </button>
    <span class="text-center" style="min-width: 4ch;">{{ $comment->rating }}</span> 
    <button class="btn btn-lg p-0 border-0" data-wt-action="comment.dislike" data-wt-comment-id="{{ $comment->id }}">
        {{-- TODO --}}
        @if($type === 'dislike')
            <i class="bi bi-hand-thumbs-down-fill wt-icon-dislike"></i>
        @else
            <i class="bi bi-hand-thumbs-down wt-icon-dislike"></i>
        @endif
        <span class="visually-hidden">Dislike</span>
    </button>
</div>
