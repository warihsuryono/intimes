<script>
    <?php if (isset($vehicle_brand)) : ?>
        $("[name='name']").val("<?= $vehicle_brand->name; ?>");
    <?php endif ?>
</script>