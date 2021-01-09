<script>
    <?php if (isset($relation)) : ?>
        $("[name='name']").val("<?= $relation->name; ?>");
    <?php endif ?>
</script>