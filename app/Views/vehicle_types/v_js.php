<script>
    <?php if (isset($vehicle_type)) : ?>
        $("[name='name']").val("<?= $vehicle_type->name; ?>");
    <?php endif ?>
</script>