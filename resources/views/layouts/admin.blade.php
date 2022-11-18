@extends('layouts.app')

@section('body')
    <header>
        @include('partials.header')
        <h1 class="text-center mt-4 text-xl font-bold tracking-wider">@yield('title')</h1>
    </header>
    <main>
        @yield('content')
    </main>
@endsection