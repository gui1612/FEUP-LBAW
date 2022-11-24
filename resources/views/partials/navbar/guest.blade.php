<nav class="navbar navbar-expand bg-light">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="{{ route('feed.show') }}">
        <img src="{{ asset('images/logo.svg') }}" alt="Wrottit logo" width="60" height="32" class="d-inline-block">
        Wrottit
    </a>
    <ul class="navbar-nav px-2">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">Login</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('register.show') }}">Register</a>
        </li>
    </ul>
  </div>
</nav>