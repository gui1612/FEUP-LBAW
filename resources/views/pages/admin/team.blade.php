@extends('layouts.app')

@section('title', 'Administrative Team')

@section('content')
    <section class="container-fluid">
        <div class="table-responsive">
            <table class="table table-hover caption-top">
                <h3 class="py-3">Administrator Team</h3>
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
                    @foreach ($paginator->items() as $admin)
                        <tr>
                            <th scope="row">{{ $admin->id }}</th>
                            <td class="d-none d-md-table-cell">{{ $admin->first_name . ' ' . $admin->last_name }}</td>
                            
                            <td><a href="{{ route('user.show', ['user'=>$admin]) }}" class="wt-hoverable text-decoration-none" style="color: var(--bs-gray-700)">{{ $admin->username }}</a></td>
                            <td>{{ $admin->email }}</td>
                            <td>
                                <button type="button" class="btn btn-danger d-flex gap-2 demote-button align-items-center" data-bs-toggle="modal" data-bs-target="#demotionWarningModal" data-wt-action="modals.admin.team.demote.open" data-wt-url="{{ route('admin.team.demote', $admin->id) }}" data-wt-username="{{$admin->username}}">
                                    <i class="bi bi-arrow-down-circle"></i>
                                    <span class="d-none d-md-block">Demote Use</span>
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="demotionWarningModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Demote <span data-wt-signal="modals.admin.team.demote.username"></span></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to demote this user?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                                <form method="POST" data-wt-signal="modals.admin.team.demote.url:action">
                                                    @csrf
                                                    @method('DELETE')
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