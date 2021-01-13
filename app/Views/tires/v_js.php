<script>
    <?php if (isset($tire)) : ?>
        $("[name='qrcode']").val("<?= $tire->qrcode; ?>");
        $("[name='serialno']").val("<?= $tire->serialno; ?>");
        $("[name='is_retread']").val("<?= $tire->is_retread; ?>");
        $("[name='tire_size_id']").val("<?= $tire->tire_size_id; ?>");
        $("[name='tire_brand_id']").val("<?= $tire->tire_brand_id; ?>");
        $("[name='tire_type_id']").val("<?= $tire->tire_type_id; ?>");
        $("[name='tread_depth']").val("<?= $tire->tread_depth; ?>");
        $("[name='pattern']").val("<?= $tire->pattern; ?>");
        $("[name='psi']").val("<?= $tire->psi; ?>");
        $("[name='remark']").val("<?= $tire->remark; ?>");
    <?php endif ?>
</script>