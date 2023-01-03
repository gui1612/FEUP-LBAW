<header>
  @auth
    @include('partials.navbar.user', ['in_forum'=>True])
  @endauth

  @guest
    @include('partials.navbar.guest')
  @endguest
</header>