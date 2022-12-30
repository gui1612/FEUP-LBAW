{{-- <a href="" class="text-decoration-none text-black">
    <div class="row bg-white p-2 my-1">
        <div class="col d-flex gap-2 align-items-center">
            <img src="{{ Auth::user()->profile_picture }}" width="30" height="30" class="rounded-circle">
            <span style="font-weight: 600">Johny just liked your post</span>
        </div>
        <div class="col-8 d-flex align-items-center">
            <span>@johny just liked your post</span>
        </div>
        <div class="col-1 d-flex align-items-center">
            <span>20 Dec</span>
        </div>
    </div>
</a>

<a href="" class="text-decoration-none text-black">
    <div class="row bg-white p-2 my-1">
        <div class="col d-flex gap-2 align-items-center">
            <img src="{{ Auth::user()->profile_picture }}" width="30" height="30" class="rounded-circle">
            <span style="font-weight: 600">Johny commented on your post</span>
        </div>
        <div class="col-8 d-flex align-items-center">
            <span>@johny commented: "I really agree with this so I'm writing this comment here to say how much I agree, I do agree a lot!"</span>
        </div>
        <div class="col-1 d-flex align-items-center">
            <span>21 Dec</span>
        </div>
    </div>
</a>

<a href="" class="text-decoration-none text-black">
    <div class="row bg-white p-2 my-1">
        <div class="col d-flex gap-2 align-items-center">
            <img src="{{ Auth::user()->profile_picture }}" width="30" height="30" class="rounded-circle">
            <span style="font-weight: 600">Johny followed you</span>
        </div>
        <div class="col-8 d-flex align-items-center">
            <span>@johny just followed you</span>
        </div>
        <div class="col-1 d-flex align-items-center">
            <span>21 Dec</span>
        </div>
    </div>
</a>

<a href="" class="text-decoration-none text-black">
    <div class="row bg-white p-2 my-1">
        <div class="col d-flex gap-2 align-items-center">
            <img src="{{ Auth::user()->profile_picture }}" width="30" height="30" class="rounded-circle">
            <span style="font-weight: 600">Content reported</span>
        </div>
        <div class="col-8 d-flex align-items-center">
            <span>Someone just reported your post. Please be aware of community rules. Contact administrators to resolve the situation.</span>
        </div>
        <div class="col-1 d-flex align-items-center">
            <span>22 Apr</span>
        </div>
    </div>
</a> --}}

{{-- secondary design its responsive!! --}}

@if($notification->type == 'follow_user')
<a href="" class="text-decoration-none text-black"> {{-- route para o user que deu follow --}}
    <div class="d-flex flex-column gap-2 bg-white p-3 my-1">
        <div class="d-flex gap-2 align-items-center">
            <img src="{{ Auth::user()->profile_picture }}" width="30" height="30" class="rounded-circle">
            <span style="font-weight: 600">username followed you</span>
            <span style="font-weight: 300">{{ date_format($notification->created_at, 'm-d') }}</span>
        </div>
        <div class="d-flex align-items-center">
            <span>username just followed you</span>
        </div>
    </div>
</a>
@endif

@if($notification->type == 'content_reported')
<a href="" class="text-decoration-none text-black">  {{-- route para o conteudo reportado --}}
    <div class="d-flex flex-column gap-2 bg-white p-3 my-1">
        <div class="d-flex gap-2 align-items-center">
            <img src="{{ Auth::user()->profile_picture }}" width="30" height="30" class="rounded-circle">
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
<a href="" class="text-decoration-none text-black"> {{-- route para o post ou comment --}}
    <div class="d-flex flex-column gap-2 bg-white p-3 my-1">
        <div class="d-flex gap-2 align-items-center">
            <img src="{{ Auth::user()->profile_picture }}" width="30" height="30" class="rounded-circle">
            <span style="font-weight: 600">username commented on your post</span>
            <span style="font-weight: 300">{{ date_format($notification->created_at, 'm-d') }}</span>
        </div>
        <div class="d-flex align-items-center">
            <span>username commented: cropped comment</span>
        </div>
    </div>
</a>
@endif

@if($notification->type == 'content_rated')
<a href="" class="text-decoration-none text-black"> {{-- route para o post ou comment --}}
    <div class="d-flex flex-column gap-2 bg-white p-3 my-1">
        <div class="d-flex gap-2 align-items-center">
            <img src="{{ Auth::user()->profile_picture }}" width="30" height="30" class="rounded-circle">
            <span style="font-weight: 600">username just liked your post</span>
            <span style="font-weight: 300">{{ date_format($notification->created_at, 'm-d') }}</span>
        </div>
        <div class="d-flex align-items-center">
            <span>username just liked your content</span>
        </div>
    </div>
</a>
@endif