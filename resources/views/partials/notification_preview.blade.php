@if($notification->type == 'follow_user')
<a href="{{ route('user.show', ['user'=>$notification->follow->owner]) }}" class="text-decoration-none text-black">
    <div class="d-flex flex-column gap-2 bg-white p-3 my-1">
        <div class="d-flex gap-2 align-items-center">
            <img src="{{ $notification->follow->owner->profile_picture_or_default_url() }}" width="30" height="30" class="rounded-circle">
            <span style="font-weight: 600">{{ $notification->follow->owner->username }} followed you</span>
            <span style="font-weight: 300">{{ date_format($notification->created_at, 'm-d') }}</span>
        </div>
        <div class="d-flex align-items-center">
            <span>{{ $notification->follow->owner->username }} just followed you</span>
        </div>
    </div>
</a>
@endif

@if($notification->type == 'content_reported')
    @if($notification->report->post  != NULL)
    <a href="{{ route('post', ['post'=>$notification->report->post]) }}" class="text-decoration-none text-black">  {{-- route para o conteudo reportado --}}
    @endif
    @if($notification->report->comment  != NULL)
    <a href="{{ route('post', ['post'=>$notification->report->comment->post]) }}" class="text-decoration-none text-black">  {{-- route para o conteudo reportado --}}
    @endif
    @if($notification->report->forum  != NULL)
    <a href="" class="text-decoration-none text-black">  {{-- route para o forum reportado --}}
    @endif
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
            <span>{{ $notification->comment->owner->username }} commented: {{ Str::limit($notification->comment->body, 250) }}</span>
        </div>
    </div>
</a>
@endif

@if($notification->type == 'content_rated')
    @if($notification->rating->comment == NULL)
        <a href="{{ route('post', ['post'=>$notification->rating->post]) }}" class="text-decoration-none text-black"> {{-- route para o post ou comment --}}
            <div class="d-flex flex-column gap-2 bg-white p-3 my-1">
                <div class="d-flex gap-2 align-items-center">
                    <img src="{{ $notification->rating->owner->profile_picture_or_default_url() }}" width="30" height="30" class="rounded-circle">
                    <span style="font-weight: 600">{{ $notification->rating->owner->username }} just liked your post</span>
                    <span style="font-weight: 300">{{ date_format($notification->created_at, 'm-d') }}</span>
                </div>
                <div class="d-flex align-items-center">
                    <span>{{ $notification->rating->owner->username }} just liked your post</span>
                </div>
            </div>
        </a>
    @else
        <a href="{{ route('post', ['post'=>$notification->rating->comment->post]) }}" class="text-decoration-none text-black"> {{-- route para o post ou comment --}}
            <div class="d-flex flex-column gap-2 bg-white p-3 my-1">
                <div class="d-flex gap-2 align-items-center">
                    <img src="{{ $notification->rating->owner->profile_picture_or_default_url() }}" width="30" height="30" class="rounded-circle">
                    <span style="font-weight: 600">{{ $notification->rating->owner->username }} just liked your comment</span>
                    <span style="font-weight: 300">{{ date_format($notification->created_at, 'm-d') }}</span>
                </div>
                <div class="d-flex align-items-center">
                    <span>{{ $notification->rating->owner->username }} just liked your comment</span>
                </div>
            </div>
        </a>
    @endif
@endif