<header>
  @auth
    @include('partials.navbar.user_forum')
  @endauth

  @guest
    @include('partials.navbar.guest')
  @endguest
</header>