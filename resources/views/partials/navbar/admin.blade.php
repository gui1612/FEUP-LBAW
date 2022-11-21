<nav class="navbar navbar-expand navbar-dark bg-danger">
    <div class="container-fluid">
        <span class="navbar-brand">Administration</span>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="{{ route('admin.team') }}" class="nav-link">Administrators</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.users') }}" class="nav-link">Users</a>
            </li>
        </ul>
    </div>
</nav>