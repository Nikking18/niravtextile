<!DOCTYPE html>
<html lang="en">

<title>@yield('title')</title>

@include('admin.layouts.head')

<body>
<div class="loader-wrapper">
    <div class="loader-index"><span></span></div>
    <svg>
        <defs></defs>
        <filter id="goo">
            <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
            <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo"></fecolormatrix>
        </filter>
    </svg>
</div>
<!-- tap on top starts-->
<div class="tap-top"><i data-feather="chevrons-up"></i></div>
<!-- tap on tap ends-->
<!-- page-wrapper Start-->
<div class="page-wrapper compact-wrapper" id="pageWrapper">

@include('admin.layouts.topbar')
<!-- Page Body Start-->
    <div class="page-body-wrapper">
        @include('admin.layouts.sidebar')

        @yield('content')

        @include('admin.layouts.footer')
    </div>
</div>

@include('admin.layouts.scripts')

</body>
</html>
