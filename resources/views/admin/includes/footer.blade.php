</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('system/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('system/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('system/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- bs-custom-file-input -->
<script src="{{asset('system/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('system/plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('system/plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
<script src="{{asset('system/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{asset('system/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('system/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('system/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('system/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('system/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('system/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('system/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- sweetalert -->
<script src="{{asset('system/plugins/sweetalert2/sweetalert2.all.min.js')}}"></script>
<!-- toastr -->
<script src="{{asset('system/plugins/toastr/toastr.min.js')}}"></script>
<!-- DataTables  & Plugins -->
<script src="{{asset('system/plugins/DataTables/datatables.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('system/dist/js/adminlte.js')}}"></script>
@stack('js')
<script>
    var url = window.location;
    var server = window.location.origin;

    // for sidebar menu entirely but not cover treeview
    $('ul.nav-sidebar a').filter(function() {
        if (this.href) {
            return this.href == url || url.href.indexOf(this.href) == 0;
        }
    }).addClass('active');
    //Dashboard
    window.location.href == `${server}/admin` || window.location.href == `${server}/admin/` ? $('.dashboard').removeClass('bg-secondary').addClass('active') : $('.dashboard').removeClass('active').addClass('bg-secondary');

    // for the treeview
    $('ul.nav-treeview a').filter(function() {
        if (this.href) {
            return this.href == url || url.href.indexOf(this.href) == 0;
        }
    }).parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open').prev('a').addClass('active');
</script>
</body>

</html>