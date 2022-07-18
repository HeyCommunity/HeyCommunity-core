<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>HEY社区</title>
  <meta name="description" content="HeyCommunity Dashboard" />

  <!-- Favicon -->
  <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>

  <!-- Map CSS -->
  <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.css" />

  <!-- Libs CSS -->
  <link rel="stylesheet" href="{{ asset('assets/dashkit/css/libs.bundle.css') }}" />

  <!-- Theme CSS -->
  <link rel="stylesheet" href="{{ asset('assets/dashkit/css/theme.bundle.css') }}" id="stylesheetLight" />
</head>
<body>
  <!-- NAVIGATION -->
  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
      <button class="navbar-toggler me-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Form -->
      <form class="form-inline me-4 d-none d-lg-flex">
        <div class="input-group input-group-rounded input-group-merge input-group-reverse">
          <input type="search" class="form-control dropdown-toggle list-search" data-bs-toggle="dropdown" placeholder="Search not available">
          <div class="input-group-text"><i class="fe fe-search"></i></div>
        </div>
      </form>

      <!-- User -->
      <div class="navbar-user">
        <div class="dropdown">
          <a href="#" class="dropdown-toggle" role="button" data-bs-toggle="dropdown">
            <div class="avatar avatar-sm avatar-online">
              <img src="{{ asset('images/logo.png') }}" class="avatar-img rounded-circle">
            </div>
          </a>

          <!-- Menu -->
          <div class="dropdown-menu dropdown-menu-end">
            <a href="#" class="disabled dropdown-item">注册</a>
            <a href="#" class="disabled dropdown-item">登录</a>
            <hr class="dropdown-divider">
            <a href="#" class="disabled dropdown-item">暂不可用</a>
          </div>
        </div>
      </div>

      <!-- Collapse -->
      <div class="collapse navbar-collapse me-lg-auto order-lg-first" id="navbar">
        <!-- Form -->
        <form class="mt-4 mb-3 d-md-none">
          <input type="search" class="form-control form-control-rounded" placeholder="Search not available">
        </form>

        <!-- Navigation -->
        <a class="navbar-brand me-3" href="#">HEY社区</a>
        <ul class="navbar-nav me-lg-auto">
          <li class="nav-item"><a class="nav-link" href="{{ route('web.home') }}">动态</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('web.home') }}">文章</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('web.home') }}">话题</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('web.home') }}">关于</a></li>
        </ul>
      </div>
    </div>
  </nav>


  <!-- MAIN CONTENT -->
  <div class="main-content">
    <!-- MainBody -->
    @yield('mainBody')
  </div>

  <!-- JAVASCRIPT -->
  <!-- Map JS -->
  <script src='https://api.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.js'></script>

  <!-- Vendor JS -->
  <script src="{{ asset('assets/dashkit/js/vendor.bundle.js') }}" defer></script>

  <!-- Theme JS -->
  <script src="{{ asset('assets/dashkit/js/theme.bundle.js') }}" defer></script>

  <!-- Page Script -->
  @yield('pageScript')
</body>
</html>