<script>
    <?php if (isset($tire_type)) : ?>
        $("[name='name']").val("<?= $tire_type->name; ?>");
    <?php endif ?>
</script>