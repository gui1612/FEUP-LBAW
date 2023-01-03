<header>
  @auth
    @include('partials.navbar.user', ['in_forum'=>False])
  @endauth

  @guest
    @include('partials.navbar.guest')
  @endguest
</header>