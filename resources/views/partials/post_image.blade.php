<form class="col-md-11 mx-auto" method="POST" action="{{ route('post.images.remove', ['post' => $post, 'image' => $image]) }}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger d-flex gap-2">
        <i class="bi bi-x-lg me-2"></i>
        <span>{{ $image->caption }}</span>
    </button>
</form>