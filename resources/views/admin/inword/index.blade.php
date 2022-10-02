@extends('admin.layouts.master')

@section('title')
    Inward - Index
@endsection

@section('extra-css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css" />
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
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">
                                    <i data-feather="home"></i></a>
                            </li>
                            <li class="breadcrumb-item">Inward</li>
                            <li class="breadcrumb-item active"> List</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" value="01/01/2021" id="min_date" />
        <div class="container-fluid">
            <div class="card col-sm-12">
                <div class="card-body">
                    <h5 class="card-tit0le text-center">Generate Custom Inwards Reports</h5>
                    <h6 class="card-subtitle mb-2 text-muted text-center">Select Date Ranges</h6>
                    <center>
                        <div class='col-sm-4'>
                            <div class="form-group">
                                <div id="reportrange" class="pull-right"
                                     style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                    <span> </span><b class="caret"></b>
                                </div>
                            </div>
                        </div>
                    </center>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    @include('admin.layouts.message')
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-9">
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ route('admin.inwords.create') }}" style="margin-bottom: 30px;" class=" btn btn-outline-success pull-right">Create
                                                                                                                                                           Inward</a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="display" id="file_table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Party Name</th>
                                        <th>Item Name</th>
                                        <th>Quantity</th>
                                        <th>Rate</th>
                                        <th>Amount</th>
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
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $(document).ready(function () {

            //daterangepicker js start
            $(function () {
                var minDate = $('#min_date').val();
                var start = moment().subtract(29, 'days');
                var end = moment();

                function cb(start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                    startDate = start.format('MMMM D, YYYY');
                    endDate = end.format('MMMM D, YYYY');
                    yajraTable(startDate, endDate)
                }

                $('#reportrange').daterangepicker({
                    minDate: minDate,
                    maxDate: new Date(),
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    opens: 'center',

                }, cb);

                cb(start, end, 'Custom Range');
            });

            function yajraTable(startDate, endDate) {
                var startDates = startDate;
                var endDates = endDate;

                let oTable = $('#file_table');
                document.dataTable = oTable.DataTable({
                    language: {
                        "emptyTable": "<div class='empty-state-td'><img src='https://cdn.shopify.com/s/files/1/0262/4071/2726/files/emptystate-files.png'/><p>No Records Found</p></div>"
                    },
                    destroy: true,
                    dom:
                        "<'row'<'col-sm-3'l><'col-sm-5'B><'col-sm-4'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-6'i><'col-sm-6'p>>",
                    buttons: [
                        {
                            extend: 'copyHtml5',
                            text: '<i class="fa fa-copy"></i> Copy',
                            titleAttr: 'Copy',
                            title: d + ' : - INWARD REPORTS',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6]
                            },
                        },
                        {
                            extend: 'excelHtml5',
                            text: '<i class="fa fa-file-excel-o"></i> Excel',
                            titleAttr: 'Excel',
                            title: d + ' : - INWARD REPORTS',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6]
                            },
                        },
                        {
                            extend: 'pdfHtml5',
                            text: '<i class="fa fa-file-pdf-o"></i> PDF',
                            titleAttr: 'PDF',
                            title: d + ' : - INWARD REPORTS',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6]
                            },
                        },
                        {
                            extend: 'csvHtml5',
                            text: '<i class="fa fa-file-text-o"></i> CSV',
                            titleAttr: 'CSV',
                            exportOptions: {
                                modifier: {
                                    search: 'applied',
                                    order: 'applied',
                                    columns: [1, 2, 3, 4, 5]
                                }
                            }
                        },
                        {
                            extend: 'print',
                            text: '<i class="fa fa-print"></i> Print',
                            titleAttr: 'Print',
                            title: d + ' : - INWARD REPORTS',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6]
                            },
                        }
                    ],
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    lengthMenu: [[10, 25, 100, -1], [10, 25, 100, "All"]],
                    pageLength: 10,
                    searching: true,
                    order: [[0, "desc"]],
                    select: {
                        style: 'os',
                        selector: 'td:first-child'
                    },

                    ajax: {
                        url: "{{ route('admin.get-inwords-reports') }}",
                        type: 'GET',
                        data: function (d) {
                            // read start date from the element
                            d.startDate = startDates;
                            // read end date from the element
                            d.endDate = endDates;
                        },
                    },

                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', 'searchable': false, 'sortable': false},
                        {data: 'party_name', name: 'party_name'},
                        {data: 'item_name', name: 'item_name'},
                        {data: 'quantity', name: 'quantity'},
                        {data: 'rate', name: 'rate'},
                        {data: 'amount', name: 'amount'},
                        {data: 'created_at', name: 'created_at'},
                        {data: 'action', name: 'action', 'searchable': false, 'sortable': false},
                    ]
                });
                oTable.on('click', '.delete-link', function (e) {
                    e.preventDefault();

                    deleteMake(this);
                })
            }
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function deleteMake(el) {
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this Inward!",
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
                            console.log(response)
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
                            console.log(error)
                            swal("Oops!", "Something went wrong.", "error");
                        }
                    });

                } else {
                    swal("Cancelled", "Inward is safe !", "error");
                }
            });
        }
    </script>
@endsection
