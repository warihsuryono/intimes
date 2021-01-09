<script>
    <?php if (isset($division)) : ?>
        $("[name='name']").val("<?= $division->name; ?>");
        $("[name='description']").val("<?= $division->description; ?>");
    <?php endif ?>
</script>