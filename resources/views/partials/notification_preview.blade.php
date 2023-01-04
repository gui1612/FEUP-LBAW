@if($notification->type == 'follow_user')
<a href="{{ $notification->link() }}" class="text-decoration-none text-black">
    <div class="d-flex gap-2 justify-content-between align-items-center bg-white p-3 my-1">
        <div class="d-flex flex-column gap-2">
            <div class="d-flex gap-2 align-items-center">
                <img src="{{ $notification->follow->owner->profile_picture_or_default_url() }}" width="30" height="30" class="rounded-circle">
                <span style="font-weight: 600">New follower</span>
                <span style="font-weight: 300">{{ date_format($notification->created_at, 'm-d') }}</span>
            </div>
            <div class="d-flex align-items-center">
                <span>{{ $notification->body() }}</span>
            </div>
        </div>
        <form method="POST" action="{{ route('mark_as_read', ['notification'=>$notification]) }}">
            @csrf
            @method('POST')
            <button type="submit" class="d-flex gap-2 btn btn-primary">
                <i class="bi bi-check-all"></i>
                <span class="d-none d-md-block">Mark as Read<span>
            </button>
        </form>
    </div>
</a>
@endif

@if($notification->type == 'content_reported')
    <a href="{{ $notification->link() }}" class="text-decoration-none text-black"> 
        <div class="d-flex gap-2 justify-content-between align-items-center bg-white p-3 my-1">
            <div class="d-flex flex-column gap-2">
                <div class="d-flex gap-2 align-items-center">
                    <img src="{{ Auth::user()-profile_picture_or_default_url() }}" width="30" height="30" class="rounded-circle">
                    <span style="font-weight: 600">Content reported</span>
                    <span style="font-weight: 300">{{ date_format($notification->created_at, 'm-d') }}</span>
                </div>
                <div class="d-flex align-items-center">
                    <span>Someone just reported your post. Please be aware of community rules. Contact administrators to resolve the situation.</span>
                </div>
            </div>
            <form method="POST" action="{{ route('mark_as_read', ['notification'=>$notification]) }}">
                @csrf
                @method('POST')
                <button type="submit" class="d-flex gap-2 btn btn-primary">
                    <i class="bi bi-check-all"></i>
                    <span class="d-none d-md-block">Mark as Read<span>
                </button>
            </form>
        </div>
    </a>
@endif

@if($notification->type == 'post_comment')
<a href="{{ route('post', ['forum' => $notification->comment->post->forum, 'post'=>$notification->comment->post]) }}" class="text-decoration-none text-black">
    <div class="d-flex gap-2 justify-content-between align-items-center bg-white p-3 my-1">
        <div class="d-flex flex-column gap-2">
            <div class="d-flex gap-2 align-items-center">
                <img src="{{ $notification->comment->owner->profile_picture_or_default_url() }}" width="30" height="30" class="rounded-circle">
                <span style="font-weight: 600">New comment</span>
                <span style="font-weight: 300">{{ date_format($notification->created_at, 'm-d') }}</span>
            </div>
            <div class="d-flex align-items-center">
                <span>{{ $notification->comment->owner->username }} commented on your post: {{ Str::limit($notification->comment->body, 100) }}</span>
            </div>
        </div>
        <form method="POST" action="{{ route('mark_as_read', ['notification'=>$notification]) }}">
            @csrf
            @method('POST')
            <button type="submit" class="d-flex gap-2 btn btn-primary">
                <i class="bi bi-check-all"></i>
                <span class="d-none d-md-block">Mark as Read<span>
            </button>
        </form>
    </div>
</a>
@endif

@if($notification->type == 'content_rated')
    <a href="{{ $notification->link() }}" class="text-decoration-none text-black">
        <div class="d-flex gap-2 justify-content-between align-items-center bg-white p-3 my-1">
            <div class="d-flex flex-column gap-2">
                <div class="d-flex gap-2 align-items-center">
                    <img src="{{ $notification->rating->owner->profile_picture_or_default_url() }}" width="30" height="30" class="rounded-circle">
                    @if($notification->rating->type == 'like')
                    <span style="font-weight: 600">New like</span>
                    @else
                    <span style="font-weight: 600">New dislike</span>
                    @endif
                    <span style="font-weight: 300">{{ date_format($notification->created_at, 'm-d') }}</span>
                </div>
                <div class="d-flex align-items-center">
                    <span>{{ $notification->body() }}</span>
                </div>
            </div>
            <form method="POST" action="{{ route('mark_as_read', ['notification'=>$notification]) }}">
                @csrf
                @method('POST')
                <button type="submit" class="d-flex gap-2 btn btn-primary">
                    <i class="bi bi-check-all"></i>
                    <span class="d-none d-md-block">Mark as Read<span>
                </button>
            </form>
        </div>
    </a>
@endif