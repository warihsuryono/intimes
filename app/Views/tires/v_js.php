<script>
    <?php if (isset($tire)) : ?>
        $("[name='qrcode']").val("<?= $tire->qrcode; ?>");
        $("[name='serialno']").val("<?= $tire->serialno; ?>");
        $("[name='tire_size_id']").val("<?= $tire->tire_size_id; ?>");
        $("[name='tire_brand_id']").val("<?= $tire->tire_brand_id; ?>");
        $("[name='tire_type_id']").val("<?= $tire->tire_type_id; ?>");
        $("[name='tire_pattern_id']").val("<?= $tire->tire_pattern_id; ?>");
        $("[name='tread_depth']").val("<?= $tire->tread_depth; ?>");
        $("[name='psi']").val("<?= $tire->psi; ?>");
        $("[name='remark']").val("<?= str_replace(chr(13) . chr(10), "<br>", $tire->remark); ?>".replace("<br>", "\n").replace("<br>", "\n").replace("<br>", "\n").replace("<br>", "\n"));
    <?php endif ?>
</script>