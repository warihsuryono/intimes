<script>
    <?php if (isset($item_type)) : ?>
        $("[name='name']").val("<?= $item_type->name; ?>");
    <?php endif ?>
</script>