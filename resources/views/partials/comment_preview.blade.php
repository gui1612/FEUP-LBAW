<article class="container p-4 shadow mb-5 bg-white rounded">

        <div class="d-flex justify-content-between">
            @include('partials.user_info', ['user'=>$comment->owner])
            @include('partials.post_actions', ['id' => $comment->id])
        </div>
        
    @include('partials.post_body', ['preview'=>True])

    <span class="my-2" style="font-weight: 300">on {{ date_format($comment->created_at, 'Y-m-d') }}</span>

    @include('partials.rating', $comment)
</article>