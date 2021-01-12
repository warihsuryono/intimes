<script>
    <?php if (isset($tire_size)) : ?>
        $("[name='name']").val("<?= $tire_size->name; ?>");
        $("[name='diameter']").val("<?= $tire_size->diameter; ?>");
        $("[name='width']").val("<?= $tire_size->width; ?>");
        $("[name='wheel']").val("<?= $tire_size->wheel; ?>");
        $("[name='sidewall']").val("<?= $tire_size->sidewall; ?>");
        $("[name='circumference']").val("<?= $tire_size->circumference; ?>");
        $("[name='revs_mile']").val("<?= $tire_size->revs_mile; ?>");
    <?php endif ?>
</script>