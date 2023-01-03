<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="min-vh-100">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @auth
      <meta name="user-id" content="{{ Auth::id() }}">
    @endauth
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
<body class="min-vh-100 d-flex flex-column">
  @yield('body')
  <div id="wt-toast-container" class="toast-container bottom-0 end-0 position-fixed p-3">
    @foreachtoast
      <div class="toast fade wt-toast-ephemeral" style="--bs-toast-bg: #fff;" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
          <div class="bg-{{ $type }} rounded-1 me-2" style="width: 1rem; height: 1rem;"></div>
          <strong class="me-auto">{{ $category }}</strong>
          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
          <span>{{ $message }}</span>
        </div>
      </div>
    @endforeachtoast
  </div>
  <script src="https://js.pusher.com/7.2.0/pusher.min.js"></script>
  <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
</body>
</html>
