<a class="text-reset  text-decoration-none d-flex align-items-center px-5" style="font-weight:bold;" href="{{ route('forum.show', ['forum'=>$post->forum_id]) }}">
   {{ $post->forum_name($post->forum_id) }} 
</a>