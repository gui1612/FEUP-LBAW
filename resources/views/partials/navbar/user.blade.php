@php($notifications = Auth::user()->notifications()->where('read', 'false')->orderBy('created_at', 'desc')->take(5)->get())

<nav class="navbar navbar-expand-md bg-light">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('feed.show') }}">
            <img src="{{ asset('images/logo.svg') }}" alt="Wrottit logo" width="60" height="32" class="d-inline-block">
            Wrottit
        </a>
        <ul class="navbar-nav d-block d-md-none ms-auto me-2">
            <li class="nav-item">
                @include('partials.navbar.notifications.mobile', ['notifications' => $notifications])
            </li>
        </ul>
        <button class="navbar-toggler p-0 mx-2 overflow-hidden rounded-circle" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <img src="{{ Auth::user()->profile_picture_or_default_url() }}" alt="{{ Auth::user()->username }}'s profile picture" width="32" height="32" class="d-inline-block img-fluid">
        </button>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">{{ '@' . Auth::user()->username }}'s account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3 align-items-center">
                    <li class="d-md-none nav-item">
                        <a class="nav-link" href="{{ route('user.show', Auth::user()->id) }}">Profile</a>
                    </li>
                    @admin
                    <li class="nav-item"><a class="nav-link text-primary" href="{{ route('admin.team') }}">Manage Team</a></li>
                    <li class="nav-item"><a class="nav-link text-primary" href="{{ route('admin.users') }}">Manage Users</a></li>
                    <li class="nav-item"><a class="nav-link text-primary" href="{{ route('admin.forums') }}">Manage Forums</a></li>
                    <li class="nav-item"><a class="nav-link text-primary" href="{{ route('admin.reports') }}">Manage Reports</a></li>
                    @endadmin
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="{{ route('forum.create') }}">
                            <i class="d-none d-md-inline-block bi bi-plus me-1"></i>New Forum
                        </a>
                    </li>
                    @if($in_forum)
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href=" {{ route('post.create', ['forum'=>$forum]) }} ">
                            <i class="d-none d-md-inline-block bi bi-plus me-1"></i>New Post
                        </a>
                    </li>
                    @endif
                    <li class="nav-item d-none d-md-block">
                        @include('partials.navbar.notifications.widescreen', ['notifications' => $notifications])
                    </li>
                    <li>
                        <hr class="offcanvas-divider">
                    </li>
                    <li class="d-md-none nav-item">
                        <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                    </li>
                </ul>
                <div class="d-none d-md-flex dropdown mx-2 align-items-center">
                    <button class="dropdown-toggle btn p-0 border-0 d-flex align-items-center" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ Auth::user()->profile_picture_or_default_url() }}" alt="{{ Auth::user()->username }}'s profile picture" width="32" height="32" class="d-inline-block img-fluid rounded-circle">
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('user.show', Auth::user()->id) }}">Your Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>