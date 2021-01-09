<script>
    function rowtemplate() {
        var sample_no = "<input type=\"text\" class=\"form-control\" name=\"sample_no[]\">";
        var brand_id = "<select class='form-control' name='brand_id[]'>";
        <?php foreach ($item_brands as $item_brand) : ?>
            brand_id += "<option value='<?= $item_brand->id; ?>'><?= $item_brand->name; ?></option>";
        <?php endforeach ?>
        brand_id += "</select>";
        var instrument_type = "<input type=\"text\" class=\"form-control\" name=\"instrument_type[]\">";
        var partno = "<input type=\"text\" class=\"form-control\" name=\"partno[]\">";
        var serialnumber = "<input type=\"text\" class=\"form-control\" name=\"serialnumber[]\">";
        var notes = "<textarea class='form-control' name='notes[]'></textarea>";
        var instrument_condition = "<select class='form-control' name='instrument_condition[]'>";
        instrument_condition += "<option value='ON'>ON</option>";
        instrument_condition += "<option value='OFF'>OFF</option>";
        instrument_condition += "</select>";
        var markup = "<tr>";
        markup += "<td>";
        markup += " <a class='btn btn-default' onclick = \" $(this).parents('tr').remove();\"> <i class = 'fas fa-trash-alt'> </i></a>";
        markup += " <a href=\"javascript:null;\" class=\"btn btn-primary\" onclick=\"row_insert($(this).parents('tr'));\"><i class=\"fa fa-angle-up\"></i></a>";
        markup += "</td>";
        markup += "<td>" + sample_no + "</td>";
        markup += "<td>" + brand_id + "</td>";
        markup += "<td>" + instrument_type + "</td>";
        markup += "<td>" + partno + "</td>";
        markup += "<td>" + serialnumber + "</td>";
        markup += "<td>" + notes + "</td>";
        markup += "<td>" + instrument_condition + "</td>";
        markup += "</tr>";
        return markup;
    }

    $("#add-row").click(function() {
        var markup = rowtemplate();
        $("#details_body").append(markup);
    });
    <?php if (isset($instrument_acceptance_details) && count($instrument_acceptance_details) > 0) : ?>
        <?php foreach ($instrument_acceptance_details as $key => $instrument_acceptance_detail) : ?>
            $("#add-row").click();
            $("#details_body").find('input[name="sample_no[]"]')[<?= $key; ?>].value = "<?= @$instrument_acceptance_detail->sample_no; ?>";
            $("#details_body").find('select[name="brand_id[]"]')[<?= $key; ?>].value = "<?= @$instrument_acceptance_detail->brand_id; ?>";
            $("#details_body").find('input[name="instrument_type[]"]')[<?= $key; ?>].value = "<?= @$instrument_acceptance_detail->instrument_type; ?>";
            $("#details_body").find('input[name="partno[]"]')[<?= $key; ?>].value = "<?= @$instrument_acceptance_detail->partno; ?>";
            $("#details_body").find('input[name="serialnumber[]"]')[<?= $key; ?>].value = "<?= @$instrument_acceptance_detail->serialnumber; ?>";
            $("#details_body").find('textarea[name="notes[]"]')[<?= $key; ?>].value = "<?= @$instrument_acceptance_detail->notes; ?>";
            $("#details_body").find('select[name="instrument_condition[]"]')[<?= $key; ?>].value = "<?= @$instrument_acceptance_detail->instrument_condition; ?>";
        <?php endforeach ?>
    <?php endif ?>

    function row_insert(elm) {
        $(rowtemplate()).insertBefore(elm);
    }

    function accepting() {
        $('#modal_title').html('Accepting Instruments');
        $('#modal_message').html("Are you sure want to accept this Instrument Acceptance?");
        $('#modal_type').attr("class", 'modal-content');
        $('#modal_ok_link').attr("class", 'btn btn-primary');
        $('#modal_ok_link').html("Yes");
        $('#modal_ok_link').attr("href", "javascript:window.location = \"<?= base_url(); ?>/instrument_acceptance/view/<?= @$quotation->id; ?>?accepting=1\";");
        $('#modal-form').modal();
    }
</script>