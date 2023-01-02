@if(Auth::check())
<button class="btn" title="Report this content" data-bs-toggle="modal" data-bs-target="#reportModal">
    <i class="bi bi-flag text"></i>
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
            <form method="POST" action="{{ route('post.report.new', ['post' => $post]) }}">
            @elseif($content == 'comment')
            <form method="POST" action="{{ route('comment.report.new', ['post' => $comment->post, 'comment' => $comment]) }}">
            @endif 
            {{-- TODO --}}
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