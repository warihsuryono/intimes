<script>
    function rowtemplate() {
        var item_type_id = "<select class='form-control' name='item_type_id[]' onchange=\"load_scopes(this);\">";
        item_type_id += "<option value=''></option>";
        <?php foreach ($item_types as $item_type) : ?>
            item_type_id += "<option value='<?= $item_type->id; ?>'><?= $item_type->name; ?></option>";
        <?php endforeach ?>
        item_type_id += "</select>";
        var scope = "<select name=\"scope_id[]\" class=\"form-control\"></select>";
        var method = "<input type=\"text\" class=\"form-control\" name=\"method[]\" value='IK Tut 01'>";
        var is_instrument = "<select class='form-control' name='is_instrument[]'>";
        is_instrument += "<option value='1'>ok</option>";
        is_instrument += "<option value='0'>Not Ok</option>";
        is_instrument += "</select>";
        var is_personel = "<select class='form-control' name='is_personel[]'>";
        is_personel += "<option value='1'>ok</option>";
        is_personel += "<option value='0'>Not Ok</option>";
        is_personel += "</select>";
        var is_acomodation = "<select class='form-control' name='is_acomodation[]'>";
        is_acomodation += "<option value='1'>ok</option>";
        is_acomodation += "<option value='0'>Not Ok</option>";
        is_acomodation += "</select>";
        var is_gas = "<select class='form-control' name='is_gas[]'>";
        is_gas += "<option value='1'>ok</option>";
        is_gas += "<option value='0'>Not Ok</option>";
        is_gas += "</select>";
        var markup = "<tr>";
        markup += "<td>";
        markup += " <a class='btn btn-default' onclick = \" $(this).parents('tr').remove();\"> <i class = 'fas fa-trash-alt'> </i></a>";
        markup += " <a href=\"javascript:null;\" class=\"btn btn-primary\" onclick=\"row_insert($(this).parents('tr'));\"><i class=\"fa fa-angle-up\"></i></a>";
        markup += "</td>";
        markup += "<td>" + item_type_id + "</td>";
        markup += "<td>" + scope + "</td>";
        markup += "<td>" + method + "</td>";
        markup += "<td>" + is_instrument + "</td>";
        markup += "<td>" + is_personel + "</td>";
        markup += "<td>" + is_acomodation + "</td>";
        markup += "<td>" + is_gas + "</td>";
        markup += "</tr>";
        return markup;
    }

    $("#add-row").click(function() {
        var markup = rowtemplate();
        $("#details_body").append(markup);
        for (var ii = 0; ii < $("#details_body").find('select[name="item_type_id[]"]').length; ii++) {
            $("#details_body").find('select[name="item_type_id[]"]')[ii].id = "item_type_id[" + ii + "]";
            $("#details_body").find('select[name="scope_id[]"]')[ii].id = "scope_id[" + ii + "]";
            $("#details_body").find('input[name="method[]"]')[ii].id = "method[" + ii + "]";
            $("#details_body").find('select[name="is_instrument[]"]')[ii].id = "is_instrument[" + ii + "]";
            $("#details_body").find('select[name="is_personel[]"]')[ii].id = "is_personel[" + ii + "]";
            $("#details_body").find('select[name="is_acomodation[]"]')[ii].id = "is_acomodation[" + ii + "]";
            $("#details_body").find('select[name="is_gas[]"]')[ii].id = "is_gas[" + ii + "]";
        }


    });
    <?php if (isset($request_review_details) && count($request_review_details) > 0) : ?>
        <?php foreach ($request_review_details as $key => $request_review_detail) : ?>
            $("#add-row").click();
            $("#details_body").find('select[name="item_type_id[]"]')[<?= $key; ?>].value = "<?= @$request_review_detail->item_type_id; ?>";
            load_scopes(document.getElementById("item_type_id[<?= $key; ?>]"), <?= @$request_review_detail->scope_id; ?>)
            $("#details_body").find('input[name="method[]"]')[<?= $key; ?>].value = "<?= @$request_review_detail->method; ?>";
            $("#details_body").find('select[name="is_instrument[]"]')[<?= $key; ?>].value = "<?= @$request_review_detail->is_instrument; ?>";
            $("#details_body").find('select[name="is_personel[]"]')[<?= $key; ?>].value = "<?= @$request_review_detail->is_personel; ?>";
            $("#details_body").find('select[name="is_acomodation[]"]')[<?= $key; ?>].value = "<?= @$request_review_detail->is_acomodation; ?>";
            $("#details_body").find('select[name="is_gas[]"]')[<?= $key; ?>].value = "<?= @$request_review_detail->is_gas; ?>";
        <?php endforeach ?>
    <?php endif ?>

    function row_insert(elm) {
        $(rowtemplate()).insertBefore(elm);
        for (var ii = 0; ii < $("#details_body").find('select[name="item_type_id[]"]').length; ii++) {
            $("#details_body").find('select[name="item_type_id[]"]')[ii].id = "item_type_id[" + ii + "]";
            $("#details_body").find('select[name="scope_id[]"]')[ii].id = "scope_id[" + ii + "]";
            $("#details_body").find('input[name="method[]"]')[ii].id = "method[" + ii + "]";
            $("#details_body").find('select[name="is_instrument[]"]')[ii].id = "is_instrument[" + ii + "]";
            $("#details_body").find('select[name="is_personel[]"]')[ii].id = "is_personel[" + ii + "]";
            $("#details_body").find('select[name="is_acomodation[]"]')[ii].id = "is_acomodation[" + ii + "]";
            $("#details_body").find('select[name="is_gas[]"]')[ii].id = "is_gas[" + ii + "]";
        }
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

    function load_scopes(elm, selected) {
        var idx = elm.id.replace("item_type_id[", "").replace("]", "");
        selected = selected || [];
        var elm_scope_id = document.getElementById("scope_id[" + idx + "]");
        elm_scope_id.innerHTML = "<option value=''>Loading, please wait ...</option>";
        $.get("<?= base_url(); ?>/item_scope/scopes_by_type_id/" + elm.value, function(result) {
            var scopes = JSON.parse(result);
            options = "";
            for (var ii = 0; ii < scopes.length; ii++) {
                is_selected = "";
                if (selected == scopes[ii].id)
                    is_selected = "selected";
                options += "<option value=" + scopes[ii].id + " " + is_selected + ">" + scopes[ii].name + " " + scopes[ii].unit + "</option>";
            }
            elm_scope_id.innerHTML = options;
        });
    }
</script>