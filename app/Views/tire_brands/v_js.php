<script>
    <?php if (isset($tire_brand)) : ?>
        $("[name='name']").val("<?= $tire_brand->name; ?>");
    <?php endif ?>
</script>