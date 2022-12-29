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
                            
                            <td>{{ $admin->username }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.team.demote', $admin->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger d-flex gap-2 align-items-center">
                                        <i class="bi bi-arrow-down-circle"></i>
                                        <span class="d-none d-md-block">Demote Use</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $paginator}}
    </section>
@endsection