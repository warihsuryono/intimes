<script>
    <?php if (isset($tire_position)) : ?>
        $("[name='name']").val("<?= $tire_position->name; ?>");
        $("[name='code']").val("<?= $tire_position->code; ?>");
        $("[name='left_right']").val("<?= $tire_position->left_right; ?>");
        $("[name='front_rear']").val("<?= $tire_position->front_rear; ?>");
        $("[name='inner_outter']").val("<?= $tire_position->inner_outter; ?>");
    <?php endif ?>
</script>