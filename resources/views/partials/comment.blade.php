<section class="container d-flex flex-column">
    @include('partials.user_info', ['user' => $comment->owner, 'clickable'=>True])
    <p>{{ $comment->body }}</p>
</section>