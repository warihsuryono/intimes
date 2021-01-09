<script>
    <?php if (isset($item_specification)) : ?>
        $("[name='name']").val("<?= $item_specification->name; ?>");
    <?php endif ?>
</script>