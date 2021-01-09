<script>
    function rowtemplate() {
        var partno = "<input type=\"text\" class=\"form-control\" name=\"partno[]\">";
        var serialnumber = "<input type=\"text\" class=\"form-control\" name=\"serialnumber[]\">";
        var description = "<input type=\"text\" class=\"form-control\" name=\"description[]\">";
        var qty = "<input type=\"number\" class=\"form-control\" name=\"qty[]\">";
        var notes = "<input type=\"text\" class=\"form-control\" name=\"notes[]\">";
        var markup = "<tr>";
        markup += "<td>";
        markup += " <a class='btn btn-default' onclick = \" $(this).parents('tr').remove();\"> <i class = 'fas fa-trash-alt'> </i></a>";
        markup += " <a href=\"javascript:null;\" class=\"btn btn-primary\" onclick=\"row_insert($(this).parents('tr'));\"><i class=\"fa fa-angle-up\"></i></a>";
        markup += "</td>";
        markup += "<td>" + partno + "</td>";
        markup += "<td>" + serialnumber + "</td>";
        markup += "<td>" + description + "</td>";
        markup += "<td>" + qty + "</td>";
        markup += "<td>" + notes + "</td>";
        markup += "</tr>";
        return markup;
    }

    $("#add-row").click(function() {
        var markup = rowtemplate();
        $("#details_body").append(markup);
    });
    <?php if (isset($instrument_release_details) && count($instrument_release_details) > 0) : ?>
        <?php foreach ($instrument_release_details as $key => $instrument_release_detail) : ?>
            $("#add-row").click();
            $("#details_body").find('input[name="partno[]"]')[<?= $key; ?>].value = "<?= @$instrument_release_detail->partno; ?>";
            $("#details_body").find('input[name="serialnumber[]"]')[<?= $key; ?>].value = "<?= @$instrument_release_detail->serialnumber; ?>";
            $("#details_body").find('input[name="description[]"]')[<?= $key; ?>].value = "<?= @$instrument_release_detail->description; ?>";
            $("#details_body").find('input[name="qty[]"]')[<?= $key; ?>].value = "<?= @$instrument_release_detail->qty; ?>";
            $("#details_body").find('input[name="notes[]"]')[<?= $key; ?>].value = "<?= @$instrument_release_detail->notes; ?>";
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
        $('#modal_ok_link').attr("href", "javascript:window.location = \"<?= base_url(); ?>/request_reviews/view/<?= @$quotation->id; ?>?accepting=1\";");
        $('#modal-form').modal();
    }
</script>