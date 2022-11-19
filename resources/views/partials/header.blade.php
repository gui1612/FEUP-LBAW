{{-- <header class="p-3 mb-3 border-bottom">
  <nav class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
      <a href="/" class="d-flex align-items-center justify-content-center mb-2 mb-lg-0 text-dark text-decoration-none">
          <img src= {{ asset('images/logo.svg') }} alt="Wrottit logo" width="60" height="32">
          <span class="fs-4">Wrottit</span>
      </a>

      <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
        <li><a href="/" class="nav-link px-2 link-secondary">Feed</a></li>
      </ul>

      <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
        <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
      </form>

      <div class="dropdown text-end">
        <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
        </a>
        <ul class="dropdown-menu text-small">
          <li><a class="dropdown-item" href="#">New project...</a></li>
          <li><a class="dropdown-item" href="#">Settings</a></li>
          <li><a class="dropdown-item" href="#">Profile</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="#">Sign out</a></li>
        </ul>
      </div>
    </div>
  </nav>
</header> --}}

<header>
  <nav class="navbar navbar-expand-sm bg-white">
    <div class="container-fluid">
      <a class="navbar-brand d-flex align-items-center" href="/">
        <img src= {{ asset('images/logo.svg') }} alt="Wrottit logo" width="60" height="32" class="d-inline-block align-text-top">
        Wrottit
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto d-flex align-items-center gap-3">
          <li class="nav-item">
            <a class="btn btn-warning text-reset d-flex align-items-center py-0">
              <i class="bi bi-plus" style="font-size: 1.5rem"></i>New Post
            </a>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <img src=" {{ asset("images/logo.svg") }} " height="30" width="30" class="img-fluid" style="height: 2rem">
            </a>
            <ul class="dropdown-menu dropdown-menu-lg-end"">
              <li><a class="dropdown-item" href="#">Profile</a></li>
              {{-- <li><a class="dropdown-item" href="#">Another action</a></li> --}}
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Sign Out</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>

{{-- <header class="mb-4 fixed-top">
    <div class="p-3 text-center bg-white border-bottom">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-5 d-flex justify-content-center justify-content-md-start align-items-center d-none d-lg-flex">
            {{-- <a href="#!" class="ms-md-2">
                <img src=" {{ asset('images/logo.svg') }} " height="35" />
                <span>Wrottit</span>
            </a> --}}{{--
          </div>

          <div class="col-md-2 d-none d-lg-block">
            <a href="#!" class="ms-md-2 text-decoration-none text-reset h4">
                <img src=" {{ asset('images/logo.svg') }} " height="35" />
                <span>Wrottit</span>
            </a>
          </div>
  
          <div class="col-lg-5 d-flex justify-content-center justify-content-md-end align-items-center">
            <a class="text-reset me-3" href="#">
              <i class="fas fa-plus"></i>
            </a>
            <a class="text-reset me-3" href="#">
              <i class="fas fa-info-circle"></i>
            </a>
  
            <div class="dropdown">
              <a class="text-reset dropdown-toggle d-flex align-items-center hidden-arrow" href="#"
                id="navbarDropdownMenuLink" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                <img src="https://mdbootstrap.com/img/Photos/Avatars/img (31).jpg" class="rounded-circle" height="35"
                  alt="" loading="lazy" />
              </a>

              <li class="nav-item dropup">
                <a class="nav-link dropdown-toggle" href="#" id="dropdown10" data-toggle="dropdown" aria-expanded="false">Dropup</a>
                <ul class="dropdown-menu" aria-labelledby="dropdown10">
                  <li><a class="dropdown-item" href="#">Action</a></li>
                  <li><a class="dropdown-item" href="#">Another action</a></li>
                  <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
              </li>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Jumbotron -->
  </header> --}}

{{-- <header>
    <nav class="headernav">
        <h2>
            <a class="headernav_logo">
                <img src= {{ asset('images/logo.svg') }} alt="Wrottit logo" width="60" height="60">
                <span>Wrottit</span>
            </a>
        </h2>
    
        <div class="headernav_navigation">
            <div>
                <a class="headernav_navigation_new_post">
                    <img src= {{ asset('images/icons/plus.svg') }} alt="Create a post" width="30" height="30">
                </a>
            </div>
    
            <div>
                <a class="headernav_navigation_user_profile">
                    <img src= {{ asset('images/logo.svg') }} alt="My profile" width="60" height="60">
                </a>
            </div>
        </div>
    
    </nav>
</header> --}}