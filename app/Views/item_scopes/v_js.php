<script>
    <?php if (isset($item_scope)) : ?>
        $("[name='item_type_id']").val("<?= $item_scope->item_type_id; ?>");
        $("[name='name']").val("<?= $item_scope->name; ?>");
        $("[name='unit_id']").val("<?= $item_scope->unit_id; ?>");
        $("[name='add_price']").val("<?= $item_scope->add_price; ?>");
        $("[name='price_currency_id']").val("<?= $item_scope->price_currency_id; ?>");
    <?php endif ?>
</script>