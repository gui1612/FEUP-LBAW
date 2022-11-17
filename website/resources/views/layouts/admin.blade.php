@extends('layouts.app')

@section('body')
    <header>
        @include('partials.admin.navbar')
    </header>
    <main>
        @yield('content')
    </main>
@endsection