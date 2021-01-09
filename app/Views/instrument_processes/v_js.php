<script>
    function rowtemplate() {
        var check_notes = "<input type=\"text\" class=\"form-control\" name=\"check_notes[]\">";
        var instrument_condition = "<select class='form-control' name='instrument_condition[]'>";
        instrument_condition += "<option value='1'>ok</option>";
        instrument_condition += "<option value='0'>Not Ok</option>";
        instrument_condition += "</select>";
        var markup = "<tr>";
        markup += "<td>";
        markup += " <a class='btn btn-default' onclick = \" $(this).parents('tr').remove();\"> <i class = 'fas fa-trash-alt'> </i></a>";
        markup += " <a href=\"javascript:null;\" class=\"btn btn-primary\" onclick=\"row_insert($(this).parents('tr'));\"><i class=\"fa fa-angle-up\"></i></a>";
        markup += "</td>";
        markup += "<td>" + check_notes + "</td>";
        markup += "<td>" + instrument_condition + "</td>";
        markup += "</tr>";
        return markup;
    }

    $("#add-row").click(function() {
        var markup = rowtemplate();
        $("#details_body").append(markup);
    });
    <?php if (isset($instrument_process_details) && count($instrument_process_details) > 0) : ?>
        <?php foreach ($instrument_process_details as $key => $instrument_process_detail) : ?>
            $("#add-row").click();
            $("#details_body").find('input[name="check_notes[]"]')[<?= $key; ?>].value = "<?= @$instrument_process_detail->check_notes; ?>";
            $("#details_body").find('select[name="instrument_condition[]"]')[<?= $key; ?>].value = "<?= @$instrument_process_detail->instrument_condition; ?>";
        <?php endforeach ?>
    <?php endif ?>

    function row_insert(elm) {
        $(rowtemplate()).insertBefore(elm);
    }

    function approving() {
        $('#modal_title').html('Approving Pengecekan dan Pengerjaan');
        $('#modal_message').html("Are you sure want to approve this Pengecekan dan Pengerjaan?");
        $('#modal_type').attr("class", 'modal-content');
        $('#modal_ok_link').attr("class", 'btn btn-primary');
        $('#modal_ok_link').html("Yes");
        $('#modal_ok_link').attr("href", "javascript:window.location = \"<?= base_url(); ?>/instrument_process/view/<?= @$quotation->id; ?>?approving=1\";");
        $('#modal-form').modal();
    }
</script>