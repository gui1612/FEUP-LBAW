@extends('layouts.base')

@section('.title')
  @hasSection ('title')
    @yield('title') |
  @endif
  {{ config('app.name', 'Laravel') }}
@endsection

@section('body')
  @include('partials.header')
  <main class="bg-secondary flex-grow-1 d-flex justify-content-center items-align-start" style="--bs-bg-opacity: .15">
    @yield('content')
  </main>
  @yield('extra')
  @include('partials.footer')
@endsection