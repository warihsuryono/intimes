<script>
    <?php if (isset($payment_type)) : ?>
        $("[name='name']").val("<?= $payment_type->name; ?>");
        $("[name='description']").val("<?= $payment_type->description; ?>");
    <?php endif ?>
</script>