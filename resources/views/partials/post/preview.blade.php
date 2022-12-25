<article class="container w-75 p-4 shadow mb-5 bg-white rounded">

    @if(!$on_profile)
        <div class="d-flex justify-content-between">
            @include('partials.user_info', ['user'=>$post->owner])
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

    <span class="my-2" style="font-weight: 300">{{ displayDate($post->created_at) }}</span>

    @include('partials.rating', $post)
</article>