<script>
    <?php if (isset($coa)) : ?>
        $("[name='coa']").val("<?= $coa->coa; ?>");
        $("[name='coa_parent']").val("<?= $coa->coa; ?>");
        $("[name='description']").val("<?= $coa->description; ?>");
    <?php endif ?>
</script>