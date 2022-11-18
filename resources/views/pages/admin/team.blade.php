@extends('layouts.admin')

@section('title', 'Administrative Team')

@section('content')
    <section>
        <ul class="container">
            @foreach ($paginator->items() as $admin)
                <li class="row">
                    <div class="col">
                        <a class="flex" href="{{ route('user.show', ['id' => $admin->id]) }}">{{ $admin->username }}</a>
                    </div>
                    <form class="col bg-primary" method="POST" action="{{ route('admin.team.promote', $admin->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500">Delete</button>
                    </form>
                </li>
            @endforeach
        </ul>
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