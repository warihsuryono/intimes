<script>
    <?php if (isset($currency)) : ?>
        $("[name='id']").val("<?= $currency->id; ?>");
        $("[name='name']").val("<?= $currency->name; ?>");
        $("[name='symbol']").val("<?= $currency->symbol; ?>");
        $("[name='kurs']").val("<?= $currency->kurs; ?>");
    <?php endif ?>
</script>