<script>
    <?php if (isset($tube_brand)) : ?>
        $("[name='name']").val("<?= $tube_brand->name; ?>");
    <?php endif ?>
</script>