@extends('layouts.app')

@section('title', 'Administrative Team')

@section('content')
    <section class="container-fluid">
        <div class="table-responsive">
            <table class="table table-hover caption-top">
                <caption>Administrators</caption>
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" class="d-none d-md-table-cell">First</th>
                        <th scope="col" class="d-none d-md-table-cell">Last</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paginator->items() as $admin)
                        <tr>
                            <th scope="row">{{ $admin->id }}</th>
                            <td class="d-none d-md-table-cell">{{ $admin->first_name }}</td>
                            <td class="d-none d-md-table-cell">{{ $admin->last_name }}</td>
                            
                            <td>{{ $admin->username }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.team.promote', $admin->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
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