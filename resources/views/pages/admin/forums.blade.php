@extends('layouts.app')

@section('title', 'Administrative Team')

@section('content')
<section class="container-fluid">
  <div class="table-responsive">
    <table class="table table-hover caption-top">
      <h3 class="py-3">Forums</h3>
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col" class="d-none d-md-table-cell">Name</th>
          <th scope="col">Owner</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($paginator->items() as $forum)
        <tr>
          <th scope="row">{{ $forum->id }}</th>
          <td class="d-none d-md-table-cell">{{ $forum->name }}</td>
          <td><a href="{{ route('user.show', ['user'=>$forum->owners()->first() ]) }}" class="wt-hoverable text-decoration-none" style="color: var(--bs-gray-700)">{{ $forum->owners()->first()->username }}</a></td>
          </td>
          <td>
            <button type="button" class="btn btn-danger  d-flex gap-2 align-self-center mb-2" data-bs-toggle="modal" data-bs-target="#deletionWarningModal" data-wt-action="modals.forum.delete.open" data-wt-forum-name="{{$forum->name}}" data-wt-url="{{ route('forum.delete', ['forum' => $forum]) }}"><i class="bi bi-trash"></i>Delete Forum</button>
            <!-- Modal -->
            <div class="modal fade" id="deletionWarningModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Delete <span data-wt-signal="modals.forum.delete.name"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    Are you sure you want to delete this forum?
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <form method="POST" data-wt-signal="modals.forum.delete.url:action">
                      @csrf
                      @method('DELETE')
                      <input type="hidden" name="hidden" value="true">
                      <button class="btn btn-danger" type="submit">Yes</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  {{ $paginator}}
</section>
@endsection