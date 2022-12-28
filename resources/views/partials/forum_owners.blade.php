@php($paginator_own = $forum->posts()->visible()->paginate(10))
<section class="container-fluid mt-5 w-50">
  <div class="table-responsive">
    <table class="table table-hover caption-top" style="table-layout: fixed;">
      <caption>Forum Owners</caption>
      <thead>
        <tr>
          <th scope="col" class="d-none d-md-table-cell">Name</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($paginator->items() as $forumOwner)
        <tr>
          <td class="d-none pt-3 d-md-table-cell">@ {{ $forumOwner->owners->username }}</td>

          <td>
            <form method="POST" action="{{ route('admin.team.demote', $forum->id) }}">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger d-flex gap-2"><i class="bi bi-arrow-down-circle"></i>Demote User</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  {{ $paginator_own}}
</section>