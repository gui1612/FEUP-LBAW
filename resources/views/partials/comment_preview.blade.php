<article class="container p-4 shadow mb-5 bg-white rounded">

        <div class="d-flex gap-1 align-items-center">
            @include('partials.user_info', ['user'=>$comment->owner])
            <span>commented on <a class="wt-hoverable text-decoration-none text-dark" href="{{ route('post', ['post'=>$comment->post]) }}">{{ $comment->post->title }}</a></span>
        </div>
        
    <p>{{ $comment->body }}</p>
    <span class="my-2" style="font-weight: 300">{{ displayDate($comment->created_at) }}</span>

    <div class="mt-2">
        @include('partials.comment_rating', $comment)
    </div>
</article>