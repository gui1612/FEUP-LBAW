@extends('layouts.app')

@section('title', 'Administrative Team')

@section('content')
    <section class="container-fluid">
        <div class="table-responsive">
            <table class="table table-hover caption-top">
                <caption>Users</caption>
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" class="d-none d-md-table-cell">Name</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paginator->items() as $user)
                        <tr>
                            <th scope="row">{{ $user->id }}</th>
                            <td class="d-none d-md-table-cell">{{ $user->first_name . ' ' . $user->last_name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="d-flex gap-2">
                                @if ($user->is_admin)
                                    <button type="button" class="btn btn-danger d-flex gap-2 demote-button" data-bs-toggle="modal" data-bs-target="#demotionWarningModal" data-wt-action="modals.admin.users.demote.open" data-wt-url="{{ route('admin.team.demote', $user->id) }}" data-wt-username="{{$user->username}}"><i class="bi bi-arrow-down-circle"></i>Demote User</button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="demotionWarningModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Demote <span data-wt-signal="modals.admin.users.demote.username"></span></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to demote this user?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                                    <form method="POST" data-wt-signal="modals.admin.users.demote.url:action">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger" type="submit">Yes</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <form method="POST" action="{{ route('admin.team.promote') }}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $user->id }}">
                                        <button type="submit" class="btn btn-secondary d-flex gap-2"><i class="bi bi-arrow-up-circle"></i>Promote User</button>
                                    </form>
                                @endif
                                {{-- <form method="POST" action="{{ route('admin.user.delete', $user->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger d-flex gap-2"><i class="bi bi-trash"></i>Delete User</button>
                                </form> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $paginator}}
    </section>
@endsection