@extends('layouts.base')

@section('.title')
  @hasSection ('title')
    @yield('title') |
  @endif
  {{ config('app.name', 'Laravel') }}
@endsection

@section('body')
  <header>
    @include('partials.header')
  </header>
  <main>
    @yield('content')
  </main>
  @yield('extra')
  <footer>
    @include('partials.footer')
  </footer>
@endsection

{{-- <!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
      @hasSection ('title')
        @yield('title') | {{ config('app.name', 'Laravel') }}
      @else
        {{ config('app.name', 'Laravel') }}
      @endif
    </title>
        

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script type="text/javascript">
        // Fix for Firefox autofocus CSS bug
        // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
    </script>
    <script type="text/javascript" src={{ asset('js/app.js') }} defer>
</script>
  </head>
  <body>
    <header>
      @yield('header')
      {{-- <h1><a href="{{ url('/cards') }}">Thingy!</a></h1>
      @if (Auth::check())
      <a class="button" href="{{ url('/logout') }}"> Logout </a> <span>{{ Auth::user()->name }}</span>
      @endif --}}
    {{--</header>
    <main>
      <section id="content">
        @yield('content')
      </section>
      @yield('extra')
    </main>
    <footer>
      @yield('footer')
    </footer>
  </body>
</html> --}}
