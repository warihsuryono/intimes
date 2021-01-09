<script>
    <?php if (isset($allowance)) : ?>
        $("[name='name']").val("<?= $allowance->name; ?>");
        $("[name='description']").val("<?= $allowance->description; ?>");
    <?php endif ?>
</script>