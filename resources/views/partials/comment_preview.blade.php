<article class="container p-4 shadow mb-5 bg-white rounded">
    <div class="d-flex gap-1 align-items-center">
        @include('partials.user_info', ['user'=>$comment->owner])
        <span class="d-none d-md-block">commented on <a class="wt-hoverable text-decoration-none" href="{{ route('post', ['post'=>$comment->post, 'forum'=>$comment->post->forum]) }}">{{ Str::limit($post->title, 100) }}</a></span>
    </div>
    
    <p>{{ $comment->body }}</p>
    <span class="my-2" style="font-weight: 300">{{ displayDate($comment->created_at) }}</span>

    <div class="mt-2 d-flex gap-3">
        @include('partials.comment_rating', $comment)
        <a href="{{ route('post', ['post'=>$comment->post, 'forum'=>$post->forum]) }}" class="d-md-none wt-hoverable text-decoration-none">View post</a>
    </div>
</article>