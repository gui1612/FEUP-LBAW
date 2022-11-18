@extends('layouts.base')

@section('.title')
  @hasSection ('title')
    @yield('title') |
  @endif
  {{ config('app.name', 'Laravel') }}
@endsection

@section('body')
  @include('partials.header')
  <main>
    @yield('content')
  </main>
  @yield('extra')
  @include('partials.footer')
@endsection