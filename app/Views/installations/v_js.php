<script>
    <?php if (isset($installation)) : ?>
        $("[name='qrcode']").val("<?= $tire->qrcode; ?>");
    <?php else : ?>
        $("[name='installed_at']").val("<?= date("Y-m-d"); ?>");
    <?php endif ?>
</script>