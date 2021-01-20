<script>
    <?php if (@$_GET["qrcode"] != "" && $__mode == "add") : ?>
        $("[name='tire_qr_code']").val("<?= @$_GET["qrcode"]; ?>");
        on_qr_success("<?= @$_GET["qrcode"]; ?>");
    <?php endif ?>

    <?php if (isset($installation)) : ?>
        $("[name='tire_qr_code']").val("<?= $installation->tire_qr_code; ?>");
        on_qr_success("<?= $installation->tire_qr_code; ?>");
        $("[name='spk_no']").val("<?= $installation->spk_no; ?>");
        $("[name='spk_at']").val("<?= $installation->spk_at; ?>");
        $("[name='installed_at']").val("<?= $installation->installed_at; ?>");
        $("[name='vehicle_id']").val("<?= $installation->vehicle_id; ?>");
        $("[name='vehicle_registration_plate']").val("<?= $installation->vehicle_registration_plate; ?>");
        $("[name='tire_id']").val("<?= $installation->tire_id; ?>");
        $("[name='tire_position_id']").val("<?= $installation->tire_position_id; ?>");
        $("[name='tire_is_retread']").val("<?= $installation->tire_is_retread; ?>");
        $("[name='price']").val("<?= $installation->price; ?>");
        $("[name='flap_installation']").val("<?= $installation->flap_installation; ?>");
        $("[name='flap_price']").val("<?= $installation->flap_price; ?>");
        $("[name='disassembled_tire']").val("<?= $installation->disassembled_tire; ?>");
        $("[name='km']").val("<?= $installation->km; ?>");
        $("[name='tread_depth']").val("<?= $installation->tread_depth; ?>");
    <?php else : ?>
        $("[name='spk_at']").val("<?= date("Y-m-d"); ?>");
        $("[name='installed_at']").val("<?= date("Y-m-d"); ?>");
    <?php endif ?>
</script>