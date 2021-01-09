<script>
    $("#add-row").click(function() {
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
        var qty = "<input class='form-control text-right' name='qty[]' onkeyup='calculate()'>";
        var price = "<input class='form-control text-right' name='price[]' onkeyup='calculate()'>";
        var notes = "<input type='text' class='form-control' name='notes[]'>";
        var markup = "<tr>";
        markup += "<td><a class='btn btn-default' onclick = \" $(this).parents('tr').remove();\"> <i class = 'fas fa-trash-alt'> </i></a></td>";
        markup += "<td>" + item + "</td>";
        markup += "<td name='item_type[]'></td>";
        markup += "<td>" + scope + "</td>";
        markup += "<td>" + unit + "</td>";
        markup += "<td>" + qty + "</td>";
        markup += "<td>" + price + "</td>";
        markup += "<td>" + notes + "</td>";
        markup += "</tr>";
        $("#so_details_body").append(markup);
        for (var ii = 0; ii < $("#so_details_body").find('input[name="item_id[]"]').length; ii++) {
            $("#so_details_body").find('input[name="item_id[]"]')[ii].id = "item_id[" + ii + "]";
            $("#so_details_body").find('input[name="item_name[]"]')[ii].id = "item_name[" + ii + "]";
            $("#so_details_body").find('td[name="item_type[]"]')[ii].id = "item_type[" + ii + "]";
            $("#so_details_body").find('select[name="item_scope_ids[]"]')[ii].id = "item_scope_ids[" + ii + "]";
            $("#so_details_body").find('input[name="price[]"]')[ii].id = "price[" + ii + "]";
            $("#so_details_body").find('select[name="unit_id[]"]')[ii].id = "unit_id[" + ii + "]";
            $("#so_details_body").find('input[name="qty[]"]')[ii].id = "qty[" + ii + "]";
            $("[id='item_scope_ids[" + ii + "]']").multiselect({
                buttonWidth: '100%',
                enableFiltering: false,
                maxHeight: 300
            });
        }

        <?php if (isset($so_details) && count($so_details) > 0) : ?>
            <?php foreach ($so_details as $key => $so_detail) : ?>
                setTimeout(function() {
                    $("#so_details_body").find('select[id="item_scope_ids[<?= $key; ?>]"]').multiselect('select', [<?= str_replace("|", "", str_replace("||", ",", $so_detail->item_scope_ids)); ?>]);
                }, 500);
            <?php endforeach ?>
        <?php endif ?>

    });
    <?php if (isset($so)) : ?>
        $("[name='so_no']").val("<?= $so->so_no; ?>");
        $("[name='so_at']").val("<?= $so->so_at; ?>");
        $("[name='quotation_id']").val("<?= $so->quotation_id; ?>");
        $("[name='quotation_no']").val("<?= $so->quotation_no; ?>");
        $("[name='customer_id']").val("<?= $so->customer_id; ?>");
        $("[name='customer_name']").val("<?= $customer->company_name; ?>");
        $("[name='currency_id']").val("<?= $so->currency_id; ?>");
        $("[name='is_tax']").val("<?= $so->is_tax; ?>");
        $("[name='so_received_at']").val("<?= $so->so_received_at; ?>");
        $("[name='so_received_by']").val("<?= $so->so_received_by; ?>");
        $("[name='description']").val("<?= $so->description; ?>");
        $("[name='shipment_company']").val("<?= $so->shipment_company; ?>");
        $("[name='shipment_pic']").val("<?= $so->shipment_pic; ?>");
        $("[name='shipment_phone']").val("<?= $so->shipment_phone; ?>");
        $("[name='shipment_address']").val("<?= str_replace(chr(13) . chr(10), "<br>", $so->shipment_address); ?>".replace("<br>", "\n").replace("<br>", "\n").replace("<br>", "\n").replace("<br>", "\n"));
        $("[name='shipment_at']").val("<?= $so->shipment_at; ?>");
        $("[name='dp']").val("<?= $so->dp; ?>");
        $("[name='payment_type_id']").val("<?= $so->payment_type_id; ?>");
        $("[name='subtotal']").val("<?= $so->subtotal; ?>");
        $("[name='disc']").val("<?= $so->disc; ?>");
        $("[name='after_disc']").val("<?= $so->after_disc; ?>");
        $("[name='tax']").val("<?= $so->tax; ?>");
        $("[name='total']").val("<?= $so->total; ?>");
        $("[name='total_to_say']").val("<?= $so->total_to_say; ?>");
    <?php else : ?>
        $("[name='so_no']").val("<?= $so_no ?>");
        $("[name='so_at']").val("<?= date("Y-m-d"); ?>");
    <?php endif ?>
    <?php if (isset($so_details) && count($so_details) > 0) : ?>
        <?php foreach ($so_details as $key => $so_detail) : ?>
            $("#add-row").click();
            $("#so_details_body").find('input[name="item_id[]"]')[<?= $key; ?>].value = "<?= @$so_detail->item_id; ?>";
            $("#so_details_body").find('input[name="item_name[]"]')[<?= $key; ?>].value = "<?= @$so_detail_item[$so_detail->item_id]->name; ?>";
            document.getElementById("item_type[<?= $key; ?>]").innerHTML = "<?= @$so_detail_item[$so_detail->item_id]->name; ?>";
            $("#so_details_body").find('select[name="unit_id[]"]')[<?= $key; ?>].value = "<?= @$so_detail->unit_id; ?>";
            $("#so_details_body").find('input[name="qty[]"]')[<?= $key; ?>].value = "<?= number_format(@$so_detail->qty); ?>";
            $("#so_details_body").find('input[name="price[]"]')[<?= $key; ?>].value = "<?= number_format(@$so_detail->price); ?>";
            $("#so_details_body").find('input[name="notes[]"]')[<?= $key; ?>].value = "<?= @$so_detail->notes; ?>";
            setTimeout(function() {
                load_scopes("<?= @$so_detail->item_id; ?>", <?= $key; ?>, [<?= str_replace("|", "", str_replace("||", ",", $so_detail->item_scope_ids)); ?>]);
            }, 500);
        <?php endforeach ?>
        calculate();
    <?php endif ?>

    function approving() {
        $('#modal_title').html('Approving Sales Order');
        $('#modal_message').html("Are you sure want to approve this Sales Order?");
        $('#modal_type').attr("class", 'modal-content');
        $('#modal_ok_link').attr("class", 'btn btn-primary');
        $('#modal_ok_link').html("Yes");
        $('#modal_ok_link').attr("href", "javascript:window.location = \"<?= base_url(); ?>/so/view/<?= @$so->id; ?>?approving=1\";");
        $('#modal-form').modal();
    }

    function calculate() {
        var subtotal = 0;
        var ii = -1;
        var disc = $("[name='disc']").val().replace(",", "").replace(",", "").replace(",", "").replace(",", "").replace(",", "").replace(",", "") * 1;
        var is_tax = $("[name='is_tax']").val().replace(",", "").replace(",", "").replace(",", "").replace(",", "").replace(",", "").replace(",", "") * 1;
        $("#so_details_body").find('input[name="price[]"]').each(function() {
            ii++;
            var qty = $("#so_details_body").find('input[name="qty[]"]')[ii].value * 1;
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
        for (var ii = 0; ii < $("#so_details_body").find('input[name="item_id[]"]').length; ii++) {
            document.getElementById("item_scope_ids[" + ii + "]").name = "item_scope_ids[" + ii + "][]";
        }
        return true;
    }

    function load_scopes(item_id, idx, selected) {
        selected = selected || [];
        var elm_item_scope_ids = $("#so_details_body").find('select[id="item_scope_ids[' + idx + ']"]');
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