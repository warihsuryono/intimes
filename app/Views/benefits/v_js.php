<script>
    <?php if (isset($benefit)) : ?>
        $("[name='name']").val("<?= $benefit->name; ?>");
    <?php endif ?>
</script>