@extends('admin.layouts.master')

@section('title')
    Item - Edit
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h3>Item Management</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> <i
                                        data-feather="home"></i></a>
                            </li>
                            <li class="breadcrumb-item">Item</li>
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
                            <h5>Edit Item</h5>
                        </div>
                        <div class="card-body" style="padding-top: 0px;">
                            <form action="{{ route('admin.items.update',$item->id) }}" id="Item_form"
                                  method="post">
                                @csrf
                                @method('PUT')
                                <div class="row g-3">
                                    <input type="hidden" name="id" value="{{$item->id}}">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="item_name">Item Name:</label>
                                        <input class="form-control" id="item_name" type="text"
                                               required="" name="item_name" value="{{$item->item_name}}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="description">Description:</label>
                                        <input class="form-control" id="description" type="text"
                                               required="" name="description" value="{{$item->description}}">
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
            $('#Item_form').validate({
                rules: {
                    item_name: {
                        required: true,
                    },
                    description: {
                        required: true,
                    },
                },
                messages: {
                    item_name: "Please enter item name",
                    description: "Please enter description",
                },
            });
        });
    </script>
@endsection

