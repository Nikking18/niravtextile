@extends('admin.layouts.master')

@section('title')
    Outward - Summary
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
                        <h3>Outward - Summary</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> <i
                                        data-feather="home"></i></a>
                            </li>
                            <li class="breadcrumb-item">Outward - Summary</li>
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
                    <h5 class="card-tit0le text-center">Generate Custom Outward Summary Reports</h5>
                    <h6 class="card-subtitle mb-2 text-muted text-center">Select Date Ranges</h6>
                    <form id="outwardSummaryForm">
                        @CSRF
                        <div class="row">
                            <div class="col-sm-2">
                                <label class="form-label" for="machine_number">Machine number:</label>
                                <select name="machine_number" id="machine_number" class="form-select"
                                        aria-label="Default select example">
                                    <option value="0" selected>Select Machine</option>
                                    @foreach($machines as $machine)
                                        <option
                                            value="{{$machine}}">{{$machine}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-label" for="start_date">Start Date</label>
                                <input class="datepicker-here form-control" id="start_date" type="text"
                                       name="start_date" value="" placeholder="12/08/2021 ........" data-language="en" data-bs-original-title="" title="" autocomplete="off">
                            </div>
                            <div class="col-sm-4">
                                <label class="form-label" for="end_date">End Date</label>
                                <input class="datepicker-here form-control" id="end_date" type="text"
                                       name="end_date" value="" placeholder="12/09/2022 ......." data-language="en" data-bs-original-title="" title="" autocomplete="off">
                            </div>
                            <div class="col-sm-2">
                                <label class="form-label">&nbsp;</label>
                                <button class="form-control btn btn-primary dateSelect filter-btn" type="button">Filter</button>
                                <br>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row" id="defaultHide">
                <div class="col-sm-5">
                </div>
                <div class="col-sm-4">
                    <label class="form-label">
                        <h5>Total Amount Sum : -

                            <strong>
                                <span class="totalVal">

                                </span>
                            </strong>
                        </h5>
                    </label>
                </div>
                <div class="col-sm-3">
                </div>
            </div>

            <div class="row" id="tableRecord">
                <div class="col-sm-12">
                    @include('admin.layouts.message')
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="display" id="file_table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Item Name</th>
                                        <th>Quantity</th>
                                        <th>Machine Number</th>
                                        <th>Amount</th>
                                        <th>Person Name</th>
                                        <th>Created Date</th>
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

    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script>
        $('#tableRecord').hide();
        $('#defaultHide').hide();

        $(document).ready(function () {
            $('#outwardSummaryForm').validate({
                rules: {
                    machine_number: {
                        selectcheck: true,
                    },
                    start_date: {
                        required: true,
                    },
                    end_date: {
                        required: true,
                    },
                },
                messages: {
                    machine_number: "Please select machine number",
                    start_date: "Please select start date",
                    end_date: "Please select end date",
                },
            });

            jQuery.validator.addMethod('selectcheck', function (value) {
                return (value != '0');
            }, "Machine number is required");
        });


        $(document).ready(function () {
            $(document).on('click', '.dateSelect', function () {
                $('#tableRecord').show();
                var machineNumber = $('#machine_number').val()
                var startDate = $('#start_date').val()
                var endDate = $('#end_date').val()

                $.ajax({
                    url: "{{ route('admin.get-total-sum') }}",
                    type: 'GET',
                    data: {
                        machineNumber: machineNumber,
                        startDate: startDate,
                        endDate: endDate,
                    },
                    success: function (response) {
                        console.log(response)

                        $('#defaultHide').show();
                        $('.totalVal').text(response);

                    },
                });

                yajraTable(machineNumber, startDate, endDate)
            });


            function yajraTable(machineNumber, startDate, endDate) {
                var machineNumbers = machineNumber;
                var startDates = startDate;
                var endDates = endDate;

                let oTable = $('#file_table');
                //document.dataTable = oTable.DataTable();
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
                            title: d + ' : - OUTWARD SUMMARY REPORTS',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6]
                            },
                            messageTop: function(){
                                return "Total Outward Amount : " + $(".totalVal").text();
                            },
                        },
                        {
                            extend: 'excelHtml5',
                            text: '<i class="fa fa-file-excel-o"></i> Excel',
                            titleAttr: 'Excel',
                            title: d + ' : - OUTWARD SUMMARY REPORTS',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6]
                            },
                            messageTop: function(){
                                return "Total Outward Amount : " + $(".totalVal").text();
                            },
                        },
                        {
                            extend: 'pdfHtml5',
                            text: '<i class="fa fa-file-pdf-o"></i> PDF',
                            titleAttr: 'PDF',
                            title: d + ' : - OUTWARD SUMMARY REPORTS',
                            messageTop: function(){
                                return "Total Outward Amount : " + $(".totalVal").text();
                            },
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6]
                            },
                        },
                        {
                            extend: 'csvHtml5',
                            text: '<i class="fa fa-file-text-o"></i> CSV',
                            titleAttr: 'CSV',
                            title: d + ' : - OUTWARD SUMMARY REPORTS',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6]
                            },
                        },
                        {
                            extend: 'print',
                            text: '<i class="fa fa-print"></i> Print',
                            titleAttr: 'Print',
                            title: d + ' : - OUTWARD SUMMARY REPORTS',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6]
                            },
                            messageTop: function(){
                                return "Total Outward Amount : " + $(".totalVal").text();
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
                        url: "{{ route('admin.get-outwords-summary') }}",
                        type: 'GET',
                        data: function (d) {
                            // read machine number from the element
                            d.machineNumber = machineNumbers;
                            // read start date from the element
                            d.startDate = startDates;
                            // read end date from the element
                            d.endDate = endDates;
                        },
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', 'searchable': false, 'sortable': false},
                        {data: 'item_name', name: 'item_name'},
                        {data: 'quantity', name: 'quantity'},
                        {data: 'machine_number', name: 'machine_number'},
                        {data: 'amount', name: 'amount'},
                        {data: 'person_name', name: 'person_name'},
                        {data: 'created_at', name: 'created_at'},
                    ]
                });
            }
        });
    </script>
@endsection
