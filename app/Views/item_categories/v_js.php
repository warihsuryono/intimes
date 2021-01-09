<script>
    <?php if (isset($item_category)) : ?>
        $("[name='name']").val("<?= $item_category->name; ?>");
    <?php endif ?>
</script>