@canany(['edit', 'try_delete_post'], $post)
    <button class="ms-auto btn d-flex align-items-center gap-2 bg-white m-2 me-4" style="width: min-content" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-three-dots-vertical"></i>
        <span class="visually-hidden">Options</span>
    </button>
    <ul class="dropdown-menu dropdown-menu-end">
        @can('edit', $post)
        <li>
            <a href="{{ route('post.edit', ['forum' => $post->forum, 'post'=>$post->id]) }}" class="dropdown-item">Edit</a>
        </li>
        @endcan
        <!-- Button trigger modal -->
        @can('try_delete_post', $post)
        <li><button type="button" class="btn btn-primary dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">Delete</a></li>
        @endcan
    </ul>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this post?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <form method="POST" action="{{ route('post.delete', ['forum' => $post->forum, 'post' => $post->id])}}">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger" type="submit">Yes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endcanany