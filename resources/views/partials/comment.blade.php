<section class="container d-flex flex-column">
    <div class="d-flex align-items-center justify-content-between">
        @include('partials.user_info', ['user' => $comment->owner])
        @if(Auth::check() && ((Auth::user()->id === $comment->owner_id) || Auth::user()->is_admin || ($comment->post->forum->owners->contains(Auth::user()))))
            <div class="d-flex">
                @if (Auth::user()->id === $comment->owner_id)
                    <button id="edit-comment-button.{{ $comment->id }}" class="btn" data-wt-action="comment.edit.show" data-wt-comment-id="{{ $comment->id }}">
                        <i class="bi bi-pencil-fill"></i>
                    </button>
                @endif
                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#commentDeletionModal" data-wt-action="modals.comment.delete.open" data-wt-url="{{ route('post.comments.delete', ['post'=>$post, 'comment'=>$comment]) }}">
                    <i class="bi bi-trash-fill"></i>
                </button>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="commentDeletionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Delete Comment</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this comment?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                            <form method="POST" data-wt-signal="modals.comment.delete.url:action">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Yes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <form id="edit-comment-form.{{ $comment->id }}" method="POST" action="{{ route('post.comments.edit', ['post'=>$post, 'comment'=>$comment]) }}" enctype="multipart/form-data" class="flex-column align-items-end" style="display: none">
        @csrf
        @method('PUT')
        <label for="comment_body" class="form-label visually-hidden">Comment</label>
        <textarea id="comment_body" name="body" class="form-control w-100 mb-3 ml-3">{{ old('body') ?? $comment->body }}</textarea>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="button" id="edit-cancel-button.{{ $comment->id }}" data-wt-action="comment.edit.hide" data-wt-comment-id="{{ $comment->id }}" class="btn btn-danger">Cancel</button>
        </div>
    </form>
    <div style="padding-left: 3rem">
        <p id="comment-body.{{ $comment->id }}">{{ $comment->body }}</p>
        <span style="font-weight: 300">{{ displayDate($comment->last_edited) }}</span>

        <div class="d-flex align-items-center gap-2 mt-2">
            @include('partials.comment_rating')
            @can('report', $comment)
                @include('partials.report', ['content'=>'comment', 'comment'=>$comment])
            @endcan
        </div>
    </div>
    @if($post->comments->count() > 1)
    <hr>
    @endif
</section>