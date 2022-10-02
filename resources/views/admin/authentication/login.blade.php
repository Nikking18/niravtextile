@extends('admin.authentication.app.app')

@section('content')
    <div class="login-main">
        <form method="POST" action="{{ route('admin.check') }}" class="theme-form" id="login_Form">
            @csrf
            @include('admin.layouts.message')
            <h4>Sign in to account</h4>
            <p>Enter your email & password to login</p>
            <div class="form-group">
                <label class="col-form-label">Email Address</label>
                <input class="form-control" type="email"
                       name="email" value="{{ old('email') }}" autocomplete="off">
            </div>
            <div class="form-group">
                <label class="col-form-label">Password</label>
                <div class="form-input position-relative">
                    <input class="form-control" type="password"
                           name="password" id="password"  autocomplete="off">
                    <div class="show-hide"><span class="show"></span></div>
                </div>
            </div>
            <div class="form-group mb-0">
                <button class="btn btn-primary btn-block w-100" type="submit">Sign in</button>
            </div>
        </form>
    </div>
@endsection

@push('validation-script')
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script>
        $('.show-hide').on('click', function (){
            $(this).toggleClass("show");
            var input = $("#password");
            if (input.attr("type") === "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        $(document).ready(function () {
            $('#login_Form').validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                    },
                    password: {
                        required: true,
                        minlength: 5
                    },
                },
                messages: {
                    email: {
                        required: "Email is required",
                        email: "Email must be a valid email address",
                        maxlength: "Email cannot be more than 50 characters",
                    },
                    password: {
                        required: "Password is required",
                        minlength: "Password must be at least 5 characters"
                    },
                },
            });
        });
    </script>
@endpush



