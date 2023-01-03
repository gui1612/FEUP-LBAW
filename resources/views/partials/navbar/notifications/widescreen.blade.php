<div id="notifications-dropdown" class="dropdown mx-2 align-items-center">
    <button class="dropdown-toggle btn btn-lg p-0 border-0 d-flex align-items-center" href="#" data-bs-toggle="dropdown" aria-expanded="false">
        @if($notifications->count() > 0)
        <i class="bi bi-bell-fill"></i>
        @else
        <i class="bi bi-bell"></i>
        @endif
    </button>
    <ul class="dropdown-menu dropdown-menu-end">
        @if($notifications->count() > 0)
        @foreach($notifications as $notif)
        <li><a class="dropdown-item" href="{{ $notif->link() }}">{{ $notif->body() }}</a></li>
        @endforeach
        @else
        <span class="dropdown-item">No notifications pending</span>
        @endif
        <li>
            <hr class="dropdown-divider">
        </li>
        <li><a class="dropdown-item" href="{{ route('notifications.show_all') }}">View all</a></li>
    </ul>
</div>