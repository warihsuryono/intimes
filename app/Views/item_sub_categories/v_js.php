<script>
    <?php if (isset($item_sub_category)) : ?>
        $("[name='item_category_id']").val("<?= $item_sub_category->item_category_id; ?>");
        $("[name='name']").val("<?= $item_sub_category->name; ?>");
    <?php endif ?>
</script>