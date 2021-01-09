<script>
    <?php if (isset($item_brand)) : ?>
        $("[name='name']").val("<?= $item_brand->name; ?>");
    <?php endif ?>
</script>