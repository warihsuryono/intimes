<script>
    <?php if (isset($vehicle)) : ?>
        $("[name='registration_plate']").val("<?= $vehicle->registration_plate; ?>");
        $("[name='vehicle_type_id']").val("<?= $vehicle->vehicle_type_id; ?>");
        $("[name='vehicle_brand_id']").val("<?= $vehicle->vehicle_brand_id; ?>");
        $("[name='model']").val("<?= $vehicle->model; ?>");
        $("[name='body_no']").val("<?= $vehicle->body_no; ?>");
    <?php endif ?>
</script>