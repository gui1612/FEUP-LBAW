<article class="container p-4 shadow mb-5 bg-white rounded">

    @if(!$on_profile)
    <div class="d-flex flex-row align-items-center">
        @include('partials.user_info', ['user'=>$post->owner])
        <i class="bi bi-dot"></i>
        @include('partials.forum_info', ['forum'=>$post->forum] )
        @include('partials.post_actions', ['id' => $post->id])
    </div>
    @include('partials.post_title', ['preview'=>True])

    @else
    <div class="d-flex justify-content-between align-items-center">
        @include('partials.post_title', ['preview'=>True])
        @include('partials.post_actions', ['id' => $post->id])
    </div>
    @endif
    @include('partials.post_body', ['preview'=>True])

    <div class="d-flex align-items-center gap-1">
        <span class="my-2" style="font-weight: 300">{{ displayDate($post->created_at) }}</span>
        @if($on_profile)
        <i class="bi bi-dot"></i>
        <span>on
            <a class="text-decoration-none wt-hoverable" href="{{ route('forum.show', ['forum'=>$post->forum]) }}">{{ $post->forum->name }}</a>
        </span>
        @endif
    </div>

    <div class="d-flex mt-2">
        @include('partials.rating', $post)
    </div>
</article>