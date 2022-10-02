<!DOCTYPE html>
<html lang="en">

<title>@yield('title')</title>

@include('admin.layouts.head')

<!-- error-404 start-->
<div class="error-wrapper">
    <div class="container"><img class="img-100" src="{{asset('admin/assets/images/other-images/sad.png')}}" alt="">
        <div class="error-heading">
            <h2 class="headline font-danger">400</h2>
        </div>
        <div class="col-md-8 offset-md-2">
            <p class="sub-content">The page you are attempting to reach is currently not available. This may be because the page does not exist or has been moved.</p>
        </div>
        <div><a class="btn btn-danger-gradien btn-lg" href="{{route('admin.dashboard')}}">BACK TO HOME PAGE</a></div>
    </div>
</div>
<!-- error-404 end      -->

@include('admin.layouts.scripts')

</html>
