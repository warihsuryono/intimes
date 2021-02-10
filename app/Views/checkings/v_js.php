<script>
    <?php if (@$_GET["qrcode"] != "" && $__mode == "add") : ?>
        $("[name='tire_qr_code']").val("<?= @$_GET["qrcode"]; ?>");
        on_qr_success("<?= @$_GET["qrcode"]; ?>");
    <?php endif ?>

    <?php if (isset($checking)) : ?>
        $("[name='tire_qr_code']").val("<?= $checking->tire_qr_code; ?>");
        on_qr_success("<?= $checking->tire_qr_code; ?>");
        $("[name='spk_no']").val("<?= $checking->spk_no; ?>");
        $("[name='spk_at']").val("<?= $checking->spk_at; ?>");
        $("[name='po_price']").val("<?= $checking->po_price; ?>");
        $("[name='installed_at']").val("<?= $checking->installed_at; ?>");
        $("[name='vehicle_id']").val("<?= $checking->vehicle_id; ?>");
        $("[name='vehicle_registration_plate']").val("<?= $checking->vehicle_registration_plate; ?>");
        $("[name='tire_id']").val("<?= $checking->tire_id; ?>");
        $("[name='tire_position_id']").val("<?= $checking->tire_position_id; ?>");
        $("[name='tire_type_id']").val("<?= $checking->tire_type_id; ?>");
        $("[name='km_install']").val("<?= $checking->km_install; ?>");
        $("[name='original_tread_depth']").val("<?= $checking->original_tread_depth; ?>");
        $("[name='is_flap']").val("<?= $checking->is_flap; ?>");
        $("[name='flap_price']").val("<?= $checking->flap_price; ?>");
        $("[name='is_tube']").val("<?= $checking->is_tube; ?>");
        $("[name='tube_price']").val("<?= $checking->tube_price; ?>");
    <?php else : ?>
        $("[name='spk_at']").val("<?= date("Y-m-d"); ?>");
        $("[name='installed_at']").val("<?= date("Y-m-d"); ?>");
    <?php endif ?>
</script>