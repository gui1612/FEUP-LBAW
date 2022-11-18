@extends('layouts.admin')

@section('title', 'Administrative Team')

@section('content')
    <section>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                  </tr>
            </thead>
            <tbody>
                @foreach ($paginator->items() as $admin)
                    <tr>
                        <th scope="row">{{ $admin->id }}</th>
                        <td>{{ $admin->first_name }}</td>
                        <td>{{ $admin->last_name }}</td>
                        <td>{{ $admin->username }}</td>
                        <td>{{ $admin->email }}</td>
                        {{-- <form class="col bg-primary" method="POST" action="{{ route('admin.team.promote', $admin->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500">Delete</button>
                        </form> --}}
                    </tr>
            @endforeach
            </tbody>
        </table>
        @if ($paginator->hasPages())
            <nav>
                @if (!$paginator->onFirstPage())
                    <a href="{{ $paginator->previousPageUrl() }}">Previous</a>
                @endif
                @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                    <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
                @endfor
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}">Next</a>
                @endif
            </nav>
        @endif
    </section>
@endsection