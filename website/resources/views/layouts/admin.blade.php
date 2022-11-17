@extends('layouts.app')

@section('body')
    <header>
        @include('partials.header')
        <h1>@yield('title')</h1>
    </header>
    <main>
        @yield('content')
    </main>
@endsection