<a class="text-reset text-decoration-none d-flex align-items-center px-1 wt-hoverable" style="font-weight:500;" href="{{ route('forum.show', ['forum'=>$post->forum_id]) }}">
   {{ $post->forum_name($post->forum_id) }} 
</a>