<div class="post_content_rating">
    <button> 
        <img src= {{ asset('images/icons/like.svg') }} alt="Like this post" height="20" width="20">
    </button>
    {{ $post->rating }} 
    <button> 
        <img src= {{ asset('images/icons/dislike.svg') }} alt="Dislike this post" height="20" width="20">
    </button>
</div>