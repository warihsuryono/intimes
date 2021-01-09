<script>
    function rowtemplate() {
        var item = "<div class=\"input-group\">";
        item += "   <input type=\"hidden\" id=\"item_id[]\" name=\"item_id[]\">";
        item += "   <input type=\"text\" class=\"form-control\" id=\"item_name[]\" name=\"item_name[]\" placeholder=\"Item Name\" readonly>";
        item += "   <span class=\"input-group-btn\">";
        item += "       <button type=\"button\" class=\"btn btn-info btn-flat\" onclick=\"browse_items(this);\"><i class=\"fas fa-search\"></i></button>";
        item += "   </span>";
        item += "</div>";
        var type = "<input type=\"text\" class=\"form-control\" id=\"item_type[]\" name=\"item_type[]\" placeholder=\"Item Type ...\" readonly>";
        var scope = "<select name=\"item_scope_ids[]\" class=\"form-control\" multiple=\"multiple\"></select>";
        scope += "<input type=\"hidden\" name=\"item_scope_ids[]\">";
        var unit = "<select class='form-control' name='unit_id[]'>";
        <?php foreach ($units as $unit) : ?>
            unit += "<option value='<?= $unit->id; ?>'><?= $unit->name; ?></option>";
        <?php endforeach ?>
        unit += "</select>";
        var qty = "<input class='form-control text-right' type='number' step='0.01' style='width:100px' name='qty[]' onkeyup='calculate()'>";
        var price = "<input class='form-control text-right' type='text' name='price[]' onkeyup='calculate();formatCurrency($(this));'>";
        var notes = "<input type='text' class='form-control' name='notes[]'>";
        var markup = "<tr>";
        markup += "<td>";
        markup += " <a class='btn btn-default' onclick = \" $(this).parents('tr').remove();\"> <i class = 'fas fa-trash-alt'> </i></a>";
        markup += " <a href=\"javascript:null;\" class=\"btn btn-primary\" onclick=\"row_insert($(this).parents('tr'));\"><i class=\"fa fa-angle-up\"></i></a>";
        markup += "</td>";
        markup += "<td>" + item + "</td>";
        markup += "<td name='item_type[]'></td>";
        markup += "<td>" + scope + "</td>";
        markup += "<td>" + unit + "</td>";
        markup += "<td>" + qty + "</td>";
        markup += "<td>" + price + "</td>";
        markup += "<td>" + notes + "</td>";
        markup += "</tr>";
        return markup;
    }

    $("#add-row").click(function() {
        var markup = rowtemplate();
        $("#quotation_details_body").append(markup);
        for (var ii = 0; ii < $("#quotation_details_body").find('input[name="item_id[]"]').length; ii++) {
            $("#quotation_details_body").find('input[name="item_id[]"]')[ii].id = "item_id[" + ii + "]";
            $("#quotation_details_body").find('input[name="item_name[]"]')[ii].id = "item_name[" + ii + "]";
            $("#quotation_details_body").find('td[name="item_type[]"]')[ii].id = "item_type[" + ii + "]";
            $("#quotation_details_body").find('select[name="item_scope_ids[]"]')[ii].id = "item_scope_ids[" + ii + "]";
            $("#quotation_details_body").find('input[name="price[]"]')[ii].id = "price[" + ii + "]";
            $("#quotation_details_body").find('select[name="unit_id[]"]')[ii].id = "unit_id[" + ii + "]";
            $("#quotation_details_body").find('input[name="qty[]"]')[ii].id = "qty[" + ii + "]";
            $("[id='item_scope_ids[" + ii + "]']").multiselect({
                buttonWidth: '100%',
                enableFiltering: false,
                maxHeight: 300
            });
        }

        <?php if (isset($quotation_details) && count($quotation_details) > 0) : ?>
            <?php foreach ($quotation_details as $key => $quotation_detail) : ?>
                setTimeout(function() {
                    $("#quotation_details_body").find('select[id="item_scope_ids[<?= $key; ?>]"]').multiselect('select', [<?= str_replace("|", "", str_replace("||", ",", $quotation_detail->item_scope_ids)); ?>]);
                }, 500);
            <?php endforeach ?>
        <?php endif ?>

    });

    <?php if (isset($quotation)) : ?>
        $("[name='quotation_no']").val("<?= $quotation->quotation_no; ?>");
        <?php if (@$__mode == "revision") : ?>
            $("[name='revisi']").val("<?= $revisi; ?>");
        <?php else : ?>
            $("[name='revisi']").val("<?= $quotation->revisi; ?>");
        <?php endif ?>
        $("[name='quotation_at']").val("<?= @$quotation->quotation_at; ?>");
        $("[name='customer_id']").val("<?= @$quotation->customer_id; ?>");
        $("[name='attn']").val("<?= @$quotation->attn; ?>");
        $("[name='customer_name']").val("<?= @$customer->company_name; ?>");
        $("[name='request_no']").val("<?= @$quotation->request_no; ?>");
        $("[name='request_at']").val("<?= @$quotation->request_at; ?>");
        $("[name='currency_id']").val("<?= $quotation->currency_id; ?>");
        $("[name='is_tax']").val("<?= $quotation->is_tax; ?>");
        $("[name='description']").val("<?= $quotation->description; ?>");
        $("[name='price_notes']").val("<?= $quotation->price_notes; ?>");
        $("[name='payment_notes']").val("<?= $quotation->payment_notes; ?>");
        $("[name='execution_time']").val("<?= $quotation->execution_time; ?>");
        $("[name='execution_at']").val("<?= $quotation->execution_at; ?>");
        $("[name='validation_notes']").val("<?= $quotation->validation_notes; ?>");
        $("[name='dp']").val("<?= $quotation->dp; ?>");
        $("[name='subtotal']").val("<?= $quotation->subtotal; ?>");
        $("[name='disc']").val("<?= $quotation->disc; ?>");
        $("[name='after_disc']").val("<?= $quotation->after_disc; ?>");
        $("[name='tax']").val("<?= $quotation->tax; ?>");
        $("[name='total']").val("<?= $quotation->total; ?>");
        $("[name='total_to_say']").val("<?= $quotation->total_to_say; ?>");
    <?php else : ?>
        $("[name='quotation_no']").val("<?= $quotation_no ?>");
        $("[name='revisi']").val("0");
        $("[name='quotation_at']").val("<?= date("Y-m-d"); ?>");
        $("[name='price_notes']").val("Harga franco Jakarta");
        $("[name='payment_notes']").val("30 hari kalender setelah invoice di terima");
        $("[name='execution_time']").val("Waktu pengerjaan 7 (tujuh) hari kerja");
        $("[name='validation_notes']").val("Validasi penawaran 30 hari");
    <?php endif ?>
    <?php if (isset($quotation_details) && count($quotation_details) > 0) : ?>
        <?php foreach ($quotation_details as $key => $quotation_detail) : ?>
            $("#add-row").click();
            $("#quotation_details_body").find('input[name="item_id[]"]')[<?= $key; ?>].value = "<?= @$quotation_detail->item_id; ?>";
            $("#quotation_details_body").find('input[name="item_name[]"]')[<?= $key; ?>].value = "<?= @$quotation_detail_item[$quotation_detail->item_id]->name; ?>";
            document.getElementById("item_type[<?= $key; ?>]").innerHTML = "<?= @$quotation_detail_item_type[$quotation_detail->item_id]->name; ?>";
            $("#quotation_details_body").find('select[name="unit_id[]"]')[<?= $key; ?>].value = "<?= @$quotation_detail->unit_id; ?>";
            $("#quotation_details_body").find('input[name="qty[]"]')[<?= $key; ?>].value = "<?= number_format(@$quotation_detail->qty); ?>";
            $("#quotation_details_body").find('input[name="price[]"]')[<?= $key; ?>].value = "<?= number_format(@$quotation_detail->price); ?>";
            $("#quotation_details_body").find('input[name="notes[]"]')[<?= $key; ?>].value = "<?= @$quotation_detail->notes; ?>";
            setTimeout(function() {
                load_scopes("<?= @$quotation_detail->item_id; ?>", <?= $key; ?>, [<?= str_replace("|", "", str_replace("||", ",", $quotation_detail->item_scope_ids)); ?>]);
            }, 500);
        <?php endforeach ?>
        calculate();
    <?php endif ?>

    function row_insert(elm) {
        $(rowtemplate()).insertBefore(elm);
        for (var ii = 0; ii < $("#quotation_details_body").find('input[name="item_id[]"]').length; ii++) {
            $("#quotation_details_body").find('input[name="item_id[]"]')[ii].id = "item_id[" + ii + "]";
            $("#quotation_details_body").find('input[name="item_name[]"]')[ii].id = "item_name[" + ii + "]";
            $("#quotation_details_body").find('td[name="item_type[]"]')[ii].id = "item_type[" + ii + "]";
            $("#quotation_details_body").find('select[name="item_scope_ids[]"]')[ii].id = "item_scope_ids[" + ii + "]";
            $("#quotation_details_body").find('input[name="price[]"]')[ii].id = "price[" + ii + "]";
            $("#quotation_details_body").find('select[name="unit_id[]"]')[ii].id = "unit_id[" + ii + "]";
            $("#quotation_details_body").find('input[name="qty[]"]')[ii].id = "qty[" + ii + "]";
            $("[id='item_scope_ids[" + ii + "]']").multiselect({
                buttonWidth: '100%',
                enableFiltering: false,
                maxHeight: 300
            });
        }
    }

    function approving() {
        $('#modal_title').html('Approving Quotation');
        $('#modal_message').html("Are you sure want to approve this Quotation?");
        $('#modal_type').attr("class", 'modal-content');
        $('#modal_ok_link').attr("class", 'btn btn-primary');
        $('#modal_ok_link').html("Yes");
        $('#modal_ok_link').attr("href", "javascript:window.location = \"<?= base_url(); ?>/quotation/view/<?= @$quotation->id; ?>?approving=1\";");
        $('#modal-form').modal();
    }

    function calculate() {
        var subtotal = 0;
        var ii = -1;
        var disc = $("[name='disc']").val().replace(",", "").replace(",", "").replace(",", "").replace(",", "").replace(",", "").replace(",", "") * 1;
        var is_tax = $("[name='is_tax']").val().replace(",", "").replace(",", "").replace(",", "").replace(",", "").replace(",", "").replace(",", "") * 1;
        $("#quotation_details_body").find('input[name="price[]"]').each(function() {
            ii++;
            var qty = $("#quotation_details_body").find('input[name="qty[]"]')[ii].value.replace(",", "").replace(",", "").replace(",", "").replace(",", "").replace(",", "").replace(",", "") * 1;
            var price = $(this).val().replace(",", "").replace(",", "").replace(",", "").replace(",", "").replace(",", "").replace(",", "") * 1;
            subtotal = subtotal + (price * qty);
        });
        var discount = subtotal * disc / 100;
        var after_disc = subtotal - discount;
        var tax = after_disc / 10 * is_tax;
        var total = after_disc + tax;
        $("[name='subtotal']").val(number_format(subtotal));
        $("[name='discount']").val(number_format(discount));
        $("[name='after_disc']").val(number_format(after_disc));
        $("[name='tax']").val(number_format(tax));
        $("[name='total']").val(number_format(total));
    }

    function before_submit() {
        for (var ii = 0; ii < $("#quotation_details_body").find('input[name="item_id[]"]').length; ii++) {
            document.getElementById("item_scope_ids[" + ii + "]").name = "item_scope_ids[" + ii + "][]";
        }
        return true;
    }

    function load_scopes(item_id, idx, selected) {
        selected = selected || [];
        var elm_item_scope_ids = $("#quotation_details_body").find('select[id="item_scope_ids[' + idx + ']"]');
        elm_item_scope_ids.html("<option value=''>Loading, please wait ...</option>");
        elm_item_scope_ids.multiselect('rebuild');
        $.get("<?= base_url(); ?>/item_scope/scopes_by_item_id/" + item_id, function(result) {
            var scopes = JSON.parse(result);
            options = "";
            for (var ii = 0; ii < scopes.length; ii++) {
                options += "<option value=" + scopes[ii].id + ">" + scopes[ii].name + " " + scopes[ii].unit + "</option>";
            }
            elm_item_scope_ids.html(options);
            elm_item_scope_ids.multiselect('rebuild');
            elm_item_scope_ids.multiselect('select', selected);
        });
    }
</script>