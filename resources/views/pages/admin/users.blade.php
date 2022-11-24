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
                                    <form method="POST" action="{{ route('admin.team.demote', $user->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger d-flex gap-2"><i class="bi bi-arrow-down-circle"></i>Demote User</button>
                                    </form>
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