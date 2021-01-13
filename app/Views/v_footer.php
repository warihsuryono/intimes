</div>
<footer class="main-footer d-print-none">
    <strong>Copyright &copy; <?= date("Y"); ?> <a href="https://intimessolution.com">PT. Cahaya Berkat Abadi</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0
    </div>
</footer>

</div>
<!-- ./wrapper -->

<div class="modal fade" id="modal-form">
    <div class="modal-dialog">
        <div id="modal_type">
            <div class="modal-header">
                <h4 class="modal-title" id="modal_title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="modal_message"></p>
            </div>
            <div class="modal-footer justify-content-between">
                <a id="modal_ok_link" type="button" class="btn btn-outline-light" href="">OK</a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- jQuery -->
<script src="<?= base_url(); ?>/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?= base_url(); ?>/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script src="<?= base_url(); ?>/dist/js/currencyformatter.js"></script>
<script src="<?= base_url(); ?>/dist/js/bootstrap-multiselect.js"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?= base_url(); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?= base_url(); ?>/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?= base_url(); ?>/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?= base_url(); ?>/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?= base_url(); ?>/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?= base_url(); ?>/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?= base_url(); ?>/plugins/moment/moment.min.js"></script>
<script src="<?= base_url(); ?>/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?= base_url(); ?>/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?= base_url(); ?>/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?= base_url(); ?>/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- SweetAlert2 -->
<script src="<?= base_url(); ?>/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?= base_url(); ?>/plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url(); ?>/dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?= base_url(); ?>/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url(); ?>/dist/js/demo.js"></script>
<script>
    $(function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        <?php if (isset($_SESSION["flash_message"][1]) && $_SESSION["flash_message"][1] != "") : ?>
            Toast.fire({
                type: '<?= $_SESSION["flash_message"][0]; ?>',
                title: '<?= $_SESSION["flash_message"][1]; ?>'
            });
        <?php endif ?>
    });

    function qrcode_reader(elm_id) {
        window.open("<?= base_url(); ?>/Qr_reader?e=" + elm_id);
    }
</script>
<!-- </body></html> -->
</body>

</html>