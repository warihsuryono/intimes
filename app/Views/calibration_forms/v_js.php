<script>
    function approving() {
        $('#modal_title').html('Approving Pengecekan dan Pengerjaan');
        $('#modal_message').html("Are you sure want to approve this Pengecekan dan Pengerjaan?");
        $('#modal_type').attr("class", 'modal-content');
        $('#modal_ok_link').attr("class", 'btn btn-primary');
        $('#modal_ok_link').html("Yes");
        $('#modal_ok_link').attr("href", "javascript:window.location = \"<?= base_url(); ?>/instrument_process/view/<?= @$quotation->id; ?>?approving=1\";");
        $('#modal-form').modal();
    }
</script>