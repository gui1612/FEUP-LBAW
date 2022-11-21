<article class="container w-75 p-4 shadow mb-5 bg-white rounded">

    @if(!$on_profile)
        @include('partials.user_info', ['clickable'=>False, 'user'=>$user])
    @endif
    @include('partials.post_content', ['preview'=>True])

    <span class="my-2" style="font-weight: 300">on {{ date_format($post->created_at, 'Y-m-d') }}</span>

    @include('partials.rating', $post)
</article>