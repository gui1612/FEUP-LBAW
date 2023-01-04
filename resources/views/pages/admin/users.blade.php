@extends('layouts.app')

@section('title', 'Administrative Team')

@section('content')
<section class="container-fluid">
    <div class="table-responsive">
        <table class="table table-hover caption-top">
            <h3 class="py-3">Users</h3>
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
                    <td><a href="{{ route('user.show', ['user'=>$user]) }}" class="wt-hoverable text-decoration-none" style="color: var(--bs-gray-700)">{{ $user->username }}</a></td>
                    <td>{{ $user->email }}</td>
                    <td class="d-flex gap-2">
                        @if ($user->is_admin)
                        <button type="button" class="btn btn-danger d-flex gap-2" data-bs-toggle="modal" data-bs-target="#demotionWarningModal" data-wt-action="modals.admin.users.demote.open" data-wt-url="{{ route('admin.team.demote', $user->id) }}" data-wt-username="{{$user->username}}">
                            <i class="bi bi-arrow-down-circle"></i>
                            <span class="d-none d-md-block">Demote User</span>
                        </button>
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
                        <button type="button" class="btn btn-secondary d-flex gap-2" data-bs-toggle="modal" data-bs-target="#promotionWarningModal" data-wt-action="modals.admin.users.promote.open" data-wt-url="{{ route('admin.team.promote', $user) }}" data-wt-username="{{$user->username}}">
                            <i class="bi bi-arrow-up-circle"></i>
                            <span class="d-none d-md-flex">Promote User</span>
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="promotionWarningModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Promote <span data-wt-signal="modals.admin.users.promote.username"></span></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to promote this user?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                        <form method="POST" data-wt-signal="modals.admin.users.promote.url:action">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $user->id }}">
                                            <button class="btn btn-danger" type="submit">Yes</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if(!$user->is_admin)
                        <button type="button" class="btn btn-danger d-flex gap-2" data-bs-toggle="modal" data-bs-target="#deletionWarningModal" data-wt-action="modals.admin.users.delete.open" data-wt-url="{{ route('user.delete', $user->id) }}" data-wt-username="{{$user->username}}">
                            <i class="bi bi-trash"></i>
                            <span class="d-none d-md-block">Delete User</span>
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="deletionWarningModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Delete <span data-wt-signal="modals.admin.users.delete.username"></span></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete this user?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                        <form method="POST" data-wt-signal="modals.admin.users.delete.url:action">
                                            @csrf
                                            @method('DELETE')
                                            <!-- <input type="hidden" name="id" value="{{ $user->id }}"> -->
                                            <button class="btn btn-danger" type="submit">Yes</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @can("block", $user)
                        <button type="button" class="btn btn-danger d-flex gap-2" data-bs-toggle="modal" data-bs-target="#blockWarningModal" data-wt-action="modals.admin.users.block.open" data-wt-url="{{ route('admin.team.block', $user) }}" data-wt-username="{{$user->username}}">
                            <i class="bi bi-stop-fill"></i>
                            <span class="d-none d-md-block">Block User</span>
                        </button>
                        @elsecan("unblock", $user)
                        <button type="button" class="btn btn-secondary d-flex gap-2" data-bs-toggle="modal" data-bs-target="#unblockWarningModal" data-wt-action="modals.admin.users.unblock.open" data-wt-url="{{ route('admin.team.unblock', $user) }}" data-wt-username="{{$user->username}}">
                            <i class="bi bi-stop-fill"></i>
                            <span class="d-none d-md-block">Unblock User</span>
                        </button>
                        @endif
                        <!-- Modal -->
                        <div class="modal fade" id="blockWarningModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Block <span data-wt-signal="modals.admin.users.block.username"></span></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to block this user?</p>
                                        <form method="POST" data-wt-signal="modals.admin.users.block.url:action">
                                            @csrf
                                            <label for="block_reason">Block Reason:</label>
                                            <input type="text" class="form-control mt-1" id="block_reason" name="block_reason" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                        <button class="btn btn-danger" type="submit">Yes</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="unblockWarningModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Unblock<span data-wt-signal="modals.admin.users.unblock.username"></span></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to unblock this user?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                        <form method="POST" data-wt-signal="modals.admin.users.unblock.url:action">
                                            @csrf
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