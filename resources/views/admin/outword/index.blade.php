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
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> <i data-feather="home"></i></a>
                            </li>
                            <li class="breadcrumb-item">Outward</li>
                            <li class="breadcrumb-item active"> List</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    @include('admin.layouts.message')
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-9">
                                </div>
                                <div class="col-md-3 ">
                                    <a href="{{ route('admin.outwords.create') }}"  style="margin-bottom: 30px;" class=" btn btn-outline-success pull-right">Create
                                                                                                                               Outward</a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="display" id="file_table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Item Name</th>
                                        <th>Quantity</th>
                                        <th>Machine Number</th>
                                        <th>Person Name</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script>
        $(document).ready(function () {

            let oTable = $('#file_table');
            //document.dataTable = oTable.DataTable();
            document.dataTable = oTable.DataTable({
                dom:
                    "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-6'i><'col-sm-6'p>>",
                responsive: true,
                processing: true,
                serverSide: true,
                "pageLength": 25,
                "searching": true,
                "order": [[0, "desc"]],
                select: {
                    style: 'os',
                    selector: 'td:first-child'
                },

                ajax: {
                    url: "{{ route('admin.get-outwords') }}",
                    data: function (d) {
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', 'searchable': false, 'sortable': false},
                    {data: 'item_name', name: 'item_name'},
                    {data: 'quantity', name: 'quantity'},
                    {data: 'machine_number', name: 'machine_number'},
                    {data: 'person_name', name: 'person_name'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', 'searchable': false, 'sortable': false},
                ]
            });
            oTable.on('click', '.delete-link', function (e) {
                e.preventDefault();

                deleteMake(this);
            })
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function deleteMake(el) {
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this Outward!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            }, function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: $(el).data('remote'),
                        type: 'delete',
                        data: {_method: 'delete'},
                        dataType: 'json',
                        success: function (response) {
                            if (response.status) {
                                swal("Deleted!", response.msg, "success");
                                document.dataTable.draw();
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
                    swal("Cancelled", "Outward is safe !", "error");
                }
            });
        }
    </script>
@endsection
