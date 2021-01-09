<script>
    <?php if (isset($customer_level)) : ?>
        $("[name='name']").val("<?= $customer_level->name; ?>");
        $("[name='description']").val("<?= $customer_level->description; ?>");
    <?php endif ?>
</script>