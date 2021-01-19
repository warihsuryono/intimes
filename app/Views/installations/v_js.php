<script>
    <?php if (isset($installation)) : ?>
        $("[name='qrcode']").val("<?= $installation->qrcode; ?>");
    <?php else : ?>
        $("[name='spk_at']").val("<?= date("Y-m-d"); ?>");
        $("[name='installed_at']").val("<?= date("Y-m-d"); ?>");
    <?php endif ?>
</script>