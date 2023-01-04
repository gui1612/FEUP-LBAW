@if(Auth::check())
<button class="btn" title="Report this content" data-bs-toggle="modal" data-bs-target="#reportModal">
    <i class="bi bi-flag text mb-3"></i>
</button>
@endif

<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reportModalLabel">Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @if($content == 'post')
            <form method="POST" action="{{ route('post.report.new', ['post' => $post, 'forum'=>$post->forum]) }}">
            @elseif($content == 'comment')
            <form method="POST" action="{{ route('comment.report.new', ['post' => $comment->post, 'comment' => $comment, 'forum'=>$comment->post->forum]) }}">
            @elseif($content == 'forum')
            <form method="POST" action="{{ route('forum.report.new', ['forum' => $forum]) }}">
            @endif
                <div class="modal-body">
                    Please state the reason for your report:
                    <textarea class="w-100" name="reason"></textarea>
                </div>
                <div class="modal-footer">
                    @csrf
                    @method('post')
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>