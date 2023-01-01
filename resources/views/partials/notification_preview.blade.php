@if($notification->type == 'follow_user')
<a href="{{ route('user.show', ['user'=>$notification->follow->owner]) }}" class="text-decoration-none text-black">
    <div class="d-flex flex-column gap-2 bg-white p-3 my-1">
        <div class="d-flex gap-2 align-items-center">
            <img src="{{ $notification->follow->owner->profile_picture_or_default_url() }}" width="30" height="30" class="rounded-circle">
            <span style="font-weight: 600">New follower</span>
            <span style="font-weight: 300">{{ date_format($notification->created_at, 'm-d') }}</span>
        </div>
        <div class="d-flex align-items-center">
            <span>{{ $notification->body() }}</span>
        </div>
    </div>
</a>
@endif

@if($notification->type == 'content_reported')
    <a href="{{ $notification->link() }}" class="text-decoration-none text-black">  {{-- route para o conteudo reportado --}}
        <div class="d-flex flex-column gap-2 bg-white p-3 my-1">
            <div class="d-flex gap-2 align-items-center">
                <img src="{{ Auth::user()-profile_picture_or_default_url() }}" width="30" height="30" class="rounded-circle">
                <span style="font-weight: 600">Content reported</span>
                <span style="font-weight: 300">{{ date_format($notification->created_at, 'm-d') }}</span>
            </div>
            <div class="d-flex align-items-center">
                <span>Someone just reported your post. Please be aware of community rules. Contact administrators to resolve the situation.</span>
            </div>
        </div>
    </a>
@endif

@if($notification->type == 'post_comment')
<a href="{{ route('post', ['post'=>$notification->comment->post]) }}" class="text-decoration-none text-black"> {{-- route para o post ou comment --}}
    <div class="d-flex flex-column gap-2 bg-white p-3 my-1">
        <div class="d-flex gap-2 align-items-center">
            <img src="{{ $notification->comment->owner->profile_picture_or_default_url() }}" width="30" height="30" class="rounded-circle">
            <span style="font-weight: 600">{{ $notification->comment->owner->username }} commented on your post</span>
            <span style="font-weight: 300">{{ date_format($notification->created_at, 'm-d') }}</span>
        </div>
        <div class="d-flex align-items-center">
            <span>{{ $notification->body() }}</span>
        </div>
    </div>
</a>
@endif

@if($notification->type == 'content_rated')
    <a href="{{ $notification->link() }}" class="text-decoration-none text-black"> {{-- route para o post ou comment --}}
        <div class="d-flex flex-column gap-2 bg-white p-3 my-1">
            <div class="d-flex gap-2 align-items-center">
                <img src="{{ $notification->rating->owner->profile_picture_or_default_url() }}" width="30" height="30" class="rounded-circle">
                <span style="font-weight: 600">{{ $notification->body() }}</span>
                <span style="font-weight: 300">{{ date_format($notification->created_at, 'm-d') }}</span>
            </div>
            <div class="d-flex align-items-center">
                <span>{{ $notification->body() }}</span>
            </div>
        </div>
    </a>
@endif