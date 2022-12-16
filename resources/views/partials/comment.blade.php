<section class="container d-flex flex-column">
    <div class="d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            @include('partials.user_info', ['user' => $comment->owner, 'clickable'=>True])
            <span style="font-weight: 300">on {{ date_format($comment->last_edited, 'Y-m-d') }}</span>
        </div>
        @if(Auth::check() && ((Auth::user()->id == $comment->owner_id) || Auth::user()->is_admin))
            <div class="d-flex gap-1">
                <button id="edit-comment-button" class="btn" action=onPencilClick()>
                    <i class="bi bi-pencil-fill"></i>
                </button>
                <form method="POST" action="{{ route('post.comments.delete', ['post'=>$post, 'comment'=>$comment]) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn">
                        <i class="bi bi-trash-fill"></i>
                    </button>
                </form>
            </div>
        @endif
    </div>
    <form id="edit-comment-form" method="POST" action="{{ route('post.comments.edit', ['post'=>$post, 'comment'=>$comment]) }}" enctype="multipart/form-data" class="flex-column align-items-end" style="display: none">
        @csrf
        @method('PUT')
        <label for="comment_body" class="form-label visually-hidden">Comment</label>
        <textarea id="comment_body" name="body" class="form-control w-100 mb-3 ml-3">{{ old('body') ?? $comment->body }}</textarea>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="button" id="edit-cancel-button" class="btn btn-danger">Cancel</button>
        </div>
    </form>
    <p id="comment-body" style="padding-left: 3rem">{{ $comment->body }}</p>
</section>