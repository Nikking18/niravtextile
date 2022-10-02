@extends('admin.layouts.master')

@section('title')
    Party - Edit
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h3>Party Management</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> <i
                                        data-feather="home"></i></a>
                            </li>
                            <li class="breadcrumb-item">Party</li>
                            <li class="breadcrumb-item active"> Edit</li>
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
                            <h5>Edit Party</h5>
                        </div>
                        <div class="card-body" style="padding-top: 0px;">
                            <form action="{{ route('admin.parties.update',$party->id) }}" id="party_form"
                                  method="post">
                                @csrf
                                @method('PUT')
                                @include('admin.layouts.message')
                                <div class="row g-3">
                                    <input type="hidden" name="id" value="{{$party->id}}">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="party_name">Party Name:</label>
                                        <input class="form-control" id="party_name" type="text"
                                               required="" name="party_name" value="{{$party->party_name}}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="gst_number">GST Number:</label>
                                        <input class="form-control" id="gst_number" type="text"
                                               required="" name="gst_number" value="{{$party->gst_number}}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="mobile_number">Party Mobile Number:</label>
                                        <input class="form-control" id="mobile_number" type="text"
                                               required="" name="mobile_number" value="{{$party->mobile_number}}">
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
            $('#party_form').validate({
                rules: {
                    party_name: {
                        required: true,
                    },
                    gst_number: {
                        required: true,
                    },
                    mobile_number: {
                        required: true,
                        digits: true
                    },
                },
                messages: {
                    party_name: "Please enter party name",
                    gst_number: "Please enter gst number",
                },
            });
        });
    </script>
@endsection


