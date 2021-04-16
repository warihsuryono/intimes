<script>
    <?php if (isset($checking) && isset($checking_detail)) : ?>
        $("[name='tire_id']").val("<?= $checking_detail->tire_id; ?>");
        $("[name='tire_qr_code']").val("<?= $checking_detail->code; ?>");
        on_qr_success("<?= $checking_detail->code; ?>");
        $("[name='tire_position_id']").val("<?= $checking_detail->tire_position_id; ?>");
        <?php if ($checking_detail->tire_position_changed) : ?>
            $("[name='tire_position_changed']").attr("checked", true);
            $("#tire_position_remark_area").fadeIn();
            $("#tire_position_decision_area").fadeIn();
        <?php endif ?>
        $("[name='remark']").val("<?= $checking_detail->remark; ?>");
        $("[name='decision']").val("<?= $checking_detail->decision; ?>");
        $("[name='km']").val("<?= $checking_detail->km; ?>");
        $("[name='rtd1']").val("<?= $checking_detail->rtd1; ?>");
        $("[name='rtd2']").val("<?= $checking_detail->rtd2; ?>");
        $("[name='rtd3']").val("<?= $checking_detail->rtd3; ?>");
        $("[name='rtd4']").val("<?= $checking_detail->rtd4; ?>");
        $("[name='checking_at']").val("<?= $checking->checking_at; ?>");
        $("[name='psi_before']").val("<?= $checking_detail->psi_before; ?>");
        $("[name='psi']").val("<?= $checking_detail->psi; ?>");
        $("[name='notes']").val("<?= $checking->notes; ?>");
    <?php else : ?>
        $("[name='spk_at']").val("<?= date("Y-m-d"); ?>");
        $("[name='installed_at']").val("<?= date("Y-m-d"); ?>");
    <?php endif ?>
</script>