@extends('admin.layouts.master')

@section('title')
    Change Password
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h3>Change Password</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> <i
                                        data-feather="home"></i></a>
                            </li>
                            <li class="breadcrumb-item">Change Password</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Change Password</h5>
                        </div>
                        <div class="card-body" style="padding-top: 0px;">
                            <form action="{{ route('admin.settings.store') }}" id="settings_form" method="post">
                                @csrf
                                @include('admin.layouts.message')
                                <div class="row g-3">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="email">Enter Email:</label>
                                        <input class="form-control" id="email" type="text"
                                               required="" name="email" value="{{old('email')}}">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="password">Enter New Password:</label>
                                        <input class="form-control" id="password" type="text"
                                               required="" name="password" value="{{old('password')}}">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="confirm_password">Confirm Password:</label>
                                        <input class="form-control" id="confirm_password" type="text"
                                               required="" name="confirm_password" value="{{old('confirm_password')}}">
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#settings_form').validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                    },
                    password: {
                        required: true,
                        minlength: 5
                    },
                    confirm_password: {
                        required: true,
                        minlength: 5,
                        equalTo: "#password"
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
                    confirm_password: {
                        required: "Password is required",
                        minlength: "Password must be at least 5 characters",
                        equalTo: "Password should be same as your new password !"
                    },
                },
            });
        });
    </script>
@endsection
