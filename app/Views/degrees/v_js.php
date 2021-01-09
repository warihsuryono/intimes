<script>
    <?php if (isset($degree)) : ?>
        $("[name='name']").val("<?= $degree->name; ?>");
    <?php endif ?>
</script>