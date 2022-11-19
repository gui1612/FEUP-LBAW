<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('.title')</title>
        

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <script type="text/javascript">
        // Fix for Firefox autofocus CSS bug
        // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
    </script>
    @env('local')
      <script src="http://localhost:35729/livereload.js"></script>
    @endenv
</head>
<body>
  @yield('body')
  @if(session()->exists('error'))
    <dialog open class="bg-red-400">
      <p>{{ session('error')}}</p>
    </dialog>
  @endif
  <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
</body>
</html>
