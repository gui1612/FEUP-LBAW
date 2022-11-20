<header>
  
  @auth
    @includeWhen(Auth::user()->is_admin, 'partials.navbar.admin')
    @include('partials.navbar.user')
  @endauth

  @guest
    @include('partials.navbar.guest')
  @endguest
</header>