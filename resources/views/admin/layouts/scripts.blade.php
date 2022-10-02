<!-- latest jquery-->
<script src="{{ asset('assets/js/jquery-3.5.1.min.js')}}"></script>
<!-- Bootstrap js-->
<script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js')}}"></script>
<!-- feather icon js-->
<script src="{{ asset('assets/js/icons/feather-icon/feather.min.js')}}"></script>
<script src="{{ asset('assets/js/icons/feather-icon/feather-icon.js')}}"></script>
<!-- scrollbar js-->
<script src="{{ asset('assets/js/scrollbar/simplebar.js')}}"></script>
<script src="{{ asset('assets/js/scrollbar/custom.js')}}"></script>
<!-- Sidebar jquery-->
<script src="{{ asset('assets/js/config.js')}}"></script>
<!-- Plugins JS start-->
<script src="{{ asset('assets/js/sidebar-menu.js')}}"></script>
<script src="{{ asset('assets/js/select2/select2.full.min.js')}}"></script>
<script src="{{ asset('assets/js/chart/chartist/chartist.js')}}"></script>
<script src="{{ asset('assets/js/chart/chartist/chartist-plugin-tooltip.js')}}"></script>
<script src="{{ asset('assets/js/chart/knob/knob.min.js')}}"></script>
<script src="{{ asset('assets/js/chart/knob/knob-chart.js')}}"></script>
<script src="{{ asset('assets/js/chart/apex-chart/apex-chart.js')}}"></script>
<script src="{{ asset('assets/js/chart/apex-chart/stock-prices.js')}}"></script>
<script src="{{ asset('assets/js/notify/bootstrap-notify.min.js')}}"></script>
{{--<script src="{{ asset('assets/js/dashboard/default.js')}}"></script>--}}
<script src="{{ asset('assets/js/notify/index.js')}}"></script>
<script src="{{ asset('assets/js/datepicker/date-picker/datepicker.js')}}"></script>
<script src="{{ asset('assets/js/datepicker/date-picker/datepicker.en.js')}}"></script>
<script src="{{ asset('assets/js/datepicker/date-picker/datepicker.custom.js')}}"></script>

<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js')}}"></script>
<script src="{{ asset('admin/assets/sweetalert/sweetalert.min.js')}}"></script>
<!-- Plugins JS Ends-->
<!-- Theme js-->
<script src="{{ asset('assets/js/script.js')}}"></script>
<script src="{{ asset('assets/js/jquery.validate.min.js')}}"></script>
<script src="{{ asset('assets/js/additional-methods.min.js')}}"></script>
<!-- login js-->
<!-- Plugin used-->
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

@yield('page-script')
