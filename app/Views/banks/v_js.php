<script>
    <?php if (isset($bank)) : ?>
        $("[name='code']").val("<?= $bank->code; ?>");
        $("[name='coa']").val("<?= $bank->coa; ?>");
        $("[name='name']").val("<?= $bank->name; ?>");
        $("[name='norek']").val("<?= $bank->norek; ?>");
        $("[name='currency_id']").val("<?= $bank->currency_id; ?>");
        $("[name='is_debt']").val("<?= $bank->is_debt; ?>");
        $("[name='description']").val("<?= $bank->description; ?>");
    <?php endif ?>
</script>