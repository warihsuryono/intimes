<script>
    <?php if (isset($flap_brand)) : ?>
        $("[name='name']").val("<?= $flap_brand->name; ?>");
    <?php endif ?>
</script>