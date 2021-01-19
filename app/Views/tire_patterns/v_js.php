<script>
    <?php if (isset($tire_pattern)) : ?>
        $("[name='name']").val("<?= $tire_pattern->name; ?>");
    <?php endif ?>
</script>