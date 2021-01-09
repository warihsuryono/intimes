<script>
    <?php if (isset($unit)) : ?>
        $("[name='name']").val("<?= $unit->name; ?>");
    <?php endif ?>
</script>