<script>
    <?php if (isset($supplier_group)) : ?>
        $("[name='name']").val("<?= $supplier_group->name; ?>");
        $("[name='description']").val("<?= $supplier_group->description; ?>");
    <?php endif ?>
</script>