<div id="notifications-dropdown-mobile" class="dropdown mx-2 align-items-center">
    <a class="btn btn-lg p-0 border-0 d-flex align-items-center" href="{{ route('notifications.show_all') }}">
        @if($notifications->count() > 0)
        <i class="bi bi-bell-fill"></i>
        @else
        <i class="bi bi-bell"></i>
        @endif
    </a>
</div>