<header>
  @admin
    @include('partials.navbar.admin')
  @endadmin

  @auth
    @include('partials.navbar.user')
  @endauth

  @guest
    @include('partials.navbar.guest')
  @endguest
</header>