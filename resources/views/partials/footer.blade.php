<div class="bg-dark d-flex flex-column justify-content-between px-5 pb-3 pt-3">
    <a class="navbar-brand text-light p-2 d-flex align-items-center gap-2" href="{{ route('about') }}">
        About Us
    </a>
    <a class="navbar-brand text-light p-2 d-flex align-items-center gap-2" href="{{ route('contact')}}">
        Contact Us
    </a>
    <a class="navbar-brand text-light p-2 d-flex align-items-center gap-2" href="{{ route('features')}}">
        Main Features
    </a>
</div>
<div class="bg-dark d-flex justify-content-center">
    <a class="navbar-brand text-white d-flex align-items-center gap-2" href="/">
        <img src= {{ asset('images/logo.svg') }} alt="Wrottit logo" width="60" height="32" style="width: 1.4rem">
        Wrottit
    </a>
</div>