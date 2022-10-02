@extends('admin.layouts.master')

@section('title')
    Machine - Edit
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h3>Machine Management</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> <i
                                        data-feather="home"></i></a>
                            </li>
                            <li class="breadcrumb-item">Machine</li>
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
                            <h5>Edit Machine</h5>
                        </div>
                        <div class="card-body" style="padding-top: 0px;">
                            <form action="{{ route('admin.machines.update',$machine->id) }}" id="machine_form"
                                  method="post">
                                @csrf
                                @method('PUT')
                                @include('admin.layouts.message')
                                <div class="row g-3">
                                    <input type="hidden" name="id" value="{{$machine->id}}">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="machine_number">Machine Number:</label>
                                        <input class="form-control" id="machine_number" type="text"
                                               required="" name="machine_number" value="{{$machine->machine_number}}">
                                    </div>
                                </div>
                                <button class="btn btn-primary" id="update_btn" type="submit">Update</button>
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
            $('#machine_form').validate({
                rules: {
                    machine_number: {
                        required: true,
                        digits: true,
                    },
                },
            });

            if ($('#machine_number').val() == 'All') {
                $("input").prop('disabled', true);
                $('#update_btn').attr('disabled', 'disabled');
            } else {
                $('#update_btn').removeAttr('disabled');
            }
        });
    </script>
@endsection
