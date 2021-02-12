<script>
    <?php if (@$_GET["qrcode"] != "" && $__mode == "add") : ?>
        $("[name='tire_qr_code']").val("<?= @$_GET["qrcode"]; ?>");
        on_qr_success("<?= @$_GET["qrcode"]; ?>");
    <?php endif ?>

    <?php if (isset($checking)) : ?>
        $("[name='tire_id']").val("<?= $checking->tire_id; ?>");
        $("[name='tire_qr_code']").val("<?= $checking->tire_qr_code; ?>");
        on_qr_success("<?= $checking->tire_qr_code; ?>");
        $("[name='tire_position_id']").val("<?= $checking->tire_position_id; ?>");
        <?php if ($checking->tire_position_changed) : ?>
            $("[name='tire_position_changed']").attr("checked", true);
            $("#tire_position_remark_area").fadeIn();
        <?php endif ?>
        $("[name='tire_position_remark']").val("<?= $checking->tire_position_remark; ?>");
        $("[name='check_km']").val("<?= $checking->check_km; ?>");
        $("[name='check_at']").val("<?= $checking->check_at; ?>");
        $("[name='remain_tread_depth']").val("<?= $checking->remain_tread_depth; ?>");
        $("[name='psi']").val("<?= $checking->psi; ?>");
        $("[name='notes']").val("<?= $checking->notes; ?>");
    <?php else : ?>
        $("[name='spk_at']").val("<?= date("Y-m-d"); ?>");
        $("[name='installed_at']").val("<?= date("Y-m-d"); ?>");
    <?php endif ?>
</script>