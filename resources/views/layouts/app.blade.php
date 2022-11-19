@extends('layouts.base')

@section('.title')
  @hasSection ('title')
    @yield('title') |
  @endif
  {{ config('app.name', 'Laravel') }}
@endsection

@section('body')
  @include('partials.header')
  <main class="bg bg-secondary d-flex justify-content-center" style="--bs-bg-opacity: .15">
    @yield('content')
  </main>
  @yield('extra')
  @include('partials.footer')
@endsection