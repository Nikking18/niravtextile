@extends('admin.layouts.master')

@section('title')
    Inward - Create
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h3>Inward Management</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> <i
                                        data-feather="home"></i></a>
                            </li>
                            <li class="breadcrumb-item">Inward</li>
                            <li class="breadcrumb-item active"> Create</li>
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
                            <h5>Create Inward</h5>
                        </div>
                        <div class="card-body" style="padding-top: 0px;">
                            <form action="{{ route('admin.inwords.store') }}" id="inword_form" method="post">
                                @csrf
                                @include('admin.layouts.message')
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <label class="form-label" for="party_name">Party Name</label>
                                        <select name="party_name" class="form-select"
                                                aria-label="Default select example">
                                            <option value="0" selected>Select Product</option>
                                            @foreach($parties as $party)
                                                <option
                                                    value="{{$party->party_name}}">{{$party->party_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label" for="item_name">Item Name</label>
                                        <select name="item_name" class="form-select"
                                                aria-label="Default select example">
                                            <option value="0" selected>Select Item</option>
                                            @foreach($items as $item)
                                                <option
                                                    value="{{$item->item_name}}">{{$item->item_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label" for="quantity">Quantity:</label>
                                        <input class="form-control" id="quantity" type="text"
                                               required="" name="quantity" value="{{old('quantity')}}">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label" for="rate">Rate:</label>
                                        <input class="form-control" id="rate" type="text"
                                               required="" name="rate" value="{{old('rate')}}">
                                    </div>
                                </div>
                                <br>
                                <button class="btn btn-primary" type="submit">Submit</button>
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
            $('#inword_form').validate({
                rules: {
                    party_name: {
                        selectcheck: true,
                    },
                    item_name: {
                        selectcheck: true,
                    },
                    quantity: {
                        required: true,
                        digits: true,
                    },
                    rate: {
                        required: true,
                        digits: true
                    },
                },
                messages: {
                    party_name: "Please select party name",
                    item_name: "Please select item number",
                },
            });

            jQuery.validator.addMethod('selectcheck', function (value) {
                return (value != '0');
            }, "party name required");
        });
    </script>
@endsection
