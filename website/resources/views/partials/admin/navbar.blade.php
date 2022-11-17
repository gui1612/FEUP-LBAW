<nav>
    <div>
        <img class="w-8" src="{{ asset("images/icons/left-arrow.svg") }}" width="48" height="48">
        <h1>@yield('title')</h1>
    </div>
    <ul>
        <li><a href="{{ route('admin.team') }}">Administrators</a></li>
    </ul>
</nav>