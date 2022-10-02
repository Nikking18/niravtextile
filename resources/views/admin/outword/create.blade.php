@extends('admin.layouts.master')

@section('title')
    Outward - Create
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h3>Outward Management</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> <i
                                        data-feather="home"></i></a>
                            </li>
                            <li class="breadcrumb-item">Outward</li>
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
                            <h5>Create Outward</h5>
                        </div>
                        <div class="card-body" style="padding-top: 0px;">
                            <form id="outword_form">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-sm-4">
                                        <label class="form-label" for="item_name">Item Name:</label>
                                        <select name="item_name" id="item_name" class="form-select"
                                                aria-label="Default select example">
                                            <option value="0" selected>Select Item</option>
                                            @foreach($items as $item)
                                                <option
                                                    value="{{$item}}">{{$item}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label" for="total_quantity">Total Available Quantity:</label>
                                        <input class="form-control" id="total_quantity_id" type="text"
                                               name="total_quantity" value="" disabled>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label" for="quantity">Quantity:</label>
                                        <input class="form-control" id="quantity" type="number"
                                               name="quantity" value="{{old('quantity')}}">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label" for="machine_number">Machine Number:</label>
                                        <select name="machine_number" id="machine_number" class="form-select"
                                                aria-label="Default select example">
                                            <option value="0" selected>Select Machine</option>
                                            @foreach($machines as $machine)
                                                <option
                                                    value="{{$machine}}">{{$machine}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label" for="person_name">Person Name</label>
                                        <input class="form-control" id="person_name" type="text"
                                               name="person_name" value="{{old('person_name')}}">
                                    </div>
                                </div>
                                <br>
                                <button class="btn btn-primary" id="warningInfo" type="button">Submit</button>
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

            $('#item_name').on('change', function () {
                var itemName = this.value;
                $.ajax({
                    url: "{{route('admin.get-quantity')}}",
                    type: "POST",
                    data: {
                        itemName: itemName,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (response) {
                        $('#total_quantity_id').val(response);
                    }
                });
            });
        });

        $('#outword_form').validate({
            rules: {
                item_name: {
                    required: true,
                },
                quantity: {
                    required: true,
                    min: 1,
                    max: function () {
                        return parseInt($("#total_quantity_id").val());
                    },
                },
                machine_number: {
                    required: true,
                },
                person_name: {
                    required: true,
                },
            },
            messages: {
                item_name: {
                    required: "Item name is required",
                },
                quantity: {
                    required: "Quantity is required",
                },
                machine_number: {
                    required: "Machine number is required",
                },
                person_name: {
                    required: "Person name is required",
                },
            },
        });

        $(document).ready(function () {
            $(':input[type="button"]').prop('disabled', true);
            $('input[type="text"]').on('keyup', function () {
                if ($(this).val() != '') {
                    $(':input[type="button"]').prop('disabled', false);
                } else {
                    $(':input[type="button"]').prop('disabled', true);
                }
            });
        });


        $('#warningInfo').click(function () {
            var quantityVal = $('#quantity').val()
            var item_nameVal = $('#item_name').val()
            var machine_numberVal = $('#machine_number').val()
            var person_nameVal = $('#person_name').val()
            swal({
                title: "Are you sure? ",
                text: "You will not be able to changes in this Outward after creating Are you sure to outward this " + item_nameVal + " in machine number " + machine_numberVal + " with " + quantityVal + " quantities by this person name " + person_nameVal,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                confirmButtonText: "Yes, create it!",
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            }, function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: "{{ route('admin.outwords.store') }}",
                        type: 'post',
                        data: {
                            item_name: item_nameVal,
                            quantity: quantityVal,
                            machine_number: machine_numberVal,
                            person_name: person_nameVal,
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response.status) {
                                swal("Outward Created Successfully!", response.msg, "success");
                                setInterval(function () {
                                    window.location = '{{ route('admin.outwords.index') }}';
                                }, 1000);
                            } else if (!response.status) {
                                swal("Oops!!", response.msg, "error");
                            } else {
                                swal("Oops!", "Something went wrong.", "error");
                            }
                        },
                        error: function (error) {
                            swal("Oops!", "Something went wrong.", "error");
                        }
                    });
                } else {
                    swal("Cancelled", "Outward is not create !", "error");
                }
            });
        });

    </script>
@endsection
