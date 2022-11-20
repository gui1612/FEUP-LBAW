<article class="container w-75 p-4 shadow mb-5 bg-white rounded">

    @include('partials.post_content', ['preview'=>True])

    <span class="my-2">on {{ date_format($post->created_at, 'Y-m-d') }}</span>

    @include('partials.rating', $post)
</article>