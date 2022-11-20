<header>
  @if(optional(Auth::user())->is_admin)
    @include('partials.navbar.admin')
  @endif

  @auth
    @include('partials.navbar.user')
  @endauth

  @guest
    @include('partials.navbar.guest')
  @endguest
</header>