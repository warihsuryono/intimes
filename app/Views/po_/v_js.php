<script>
    $("#add-row").click(function() {
        var item = "<div class=\"input-group\">";
        item += "   <input type=\"hidden\" id=\"item_id[]\" name=\"item_id[]\">";
        item += "   <input type=\"text\" class=\"form-control\" id=\"item_name[]\" name=\"item_name[]\" placeholder=\"Item Name\" readonly>";
        item += "   <span class=\"input-group-btn\">";
        item += "       <button type=\"button\" class=\"btn btn-info btn-flat\" onclick=\"browse_items(this);\"><i class=\"fas fa-search\"></i></button>";
        item += "   </span>";
        item += "</div>";
        var unit = "<select class='form-control' name='unit_id[]'>";
        <?php foreach ($units as $unit) : ?>
            unit += "<option value='<?= $unit->id; ?>'><?= $unit->name; ?></option>";
        <?php endforeach ?>
        unit += "</select>";
        var qty = "<input class='form-control text-right' type='number' step='0.01' name='qty[]' onkeyup='calculate()'>";
        var price = "<input class='form-control text-right' type='number' step='0.01' name='price[]' onkeyup='calculate()'>";
        var notes = "<input type='text' class='form-control' name='notes[]'>";
        var markup = "<tr>";
        markup += "<td><a class='btn btn-default' onclick = \" $(this).parents('tr').remove();\"> <i class = 'fas fa-trash-alt'> </i></a></td>";
        markup += "<td>" + item + "</td>";
        markup += "<td>" + unit + "</td>";
        markup += "<td>" + qty + "</td>";
        markup += "<td>" + price + "</td>";
        markup += "<td>" + notes + "</td>";
        markup += "</tr>";
        $("#po_details_body").append(markup);
        for (var ii = 0; ii < $("#po_details_body").find('input[name="item_id[]"]').length; ii++) {
            $("#po_details_body").find('input[name="item_id[]"]')[ii].id = "item_id[" + ii + "]";
            $("#po_details_body").find('input[name="item_name[]"]')[ii].id = "item_name[" + ii + "]";
        }

    });
    <?php if (isset($po)) : ?>
        $("[name='po_no']").val("<?= $po->po_no; ?>");
        <?php if (@$__mode == "revision") : ?>
            $("[name='revisi']").val("<?= $revisi; ?>");
        <?php else : ?>
            $("[name='revisi']").val("<?= $po->revisi; ?>");
        <?php endif ?>
        $("[name='po_at']").val("<?= $po->po_at; ?>");
        $("[name='pr_id']").val("<?= $po->pr_id; ?>");
        $("[name='pr_no']").val("<?= $po->pr_no; ?>");
        $("[name='supplier_id']").val("<?= $po->supplier_id; ?>");
        $("[name='supplier_name']").val("<?= $supplier->company_name; ?>");
        $("[name='currency_id']").val("<?= $po->currency_id; ?>");
        $("[name='is_tax']").val("<?= $po->is_tax; ?>");
        $("[name='po_received_at']").val("<?= $po->po_received_at; ?>");
        $("[name='po_received_by']").val("<?= $po->po_received_by; ?>");
        $("[name='description']").val("<?= $po->description; ?>");
        $("[name='shipment_company']").val("<?= $po->shipment_company; ?>");
        $("[name='shipment_pic']").val("<?= $po->shipment_pic; ?>");
        $("[name='shipment_phone']").val("<?= $po->shipment_phone; ?>");
        $("[name='shipment_address']").val("<?= str_replace(chr(13) . chr(10), "<br>", $po->shipment_address); ?>".replace("<br>", "\n").replace("<br>", "\n").replace("<br>", "\n").replace("<br>", "\n"));
        $("[name='shipment_at']").val("<?= $po->shipment_at; ?>");
        $("[name='dp']").val("<?= $po->dp; ?>");
        $("[name='payment_type_id']").val("<?= $po->payment_type_id; ?>");
        $("[name='subtotal']").val("<?= $po->subtotal; ?>");
        $("[name='disc']").val("<?= $po->disc; ?>");
        $("[name='after_disc']").val("<?= $po->after_disc; ?>");
        $("[name='tax']").val("<?= $po->tax; ?>");
        $("[name='total']").val("<?= $po->total; ?>");
        $("[name='total_to_say']").val("<?= $po->total_to_say; ?>");
        $("[name='bank_notes']").val("<?= $po->bank_notes; ?>");
    <?php else : ?>
        $("[name='po_no']").val("<?= $po_no; ?>");
        $("[name='revisi']").val("0");
        $("[name='po_at']").val("<?= date("Y-m-d"); ?>");
    <?php endif ?>
    <?php if (isset($po_details) && count($po_details) > 0) : ?>
        <?php foreach ($po_details as $key => $po_detail) : ?>
            $("#add-row").click();
            $("#po_details_body").find('input[name="item_id[]"]')[<?= $key; ?>].value = "<?= @$po_detail->item_id; ?>";
            $("#po_details_body").find('input[name="item_name[]"]')[<?= $key; ?>].value = "<?= @$po_detail_item[$po_detail->item_id]->name; ?>";
            $("#po_details_body").find('select[name="unit_id[]"]')[<?= $key; ?>].value = "<?= @$po_detail->unit_id; ?>";
            $("#po_details_body").find('input[name="qty[]"]')[<?= $key; ?>].value = "<?= @$po_detail->qty; ?>";
            $("#po_details_body").find('input[name="price[]"]')[<?= $key; ?>].value = "<?= @$po_detail->price; ?>";
            $("#po_details_body").find('input[name="notes[]"]')[<?= $key; ?>].value = "<?= @$po_detail->notes; ?>";
        <?php endforeach ?>
        calculate();
    <?php endif ?>

    function approving() {
        $('#modal_title').html('Approving PO');
        $('#modal_message').html("Are you sure want to approve this PO?");
        $('#modal_type').attr("class", 'modal-content');
        $('#modal_ok_link').attr("class", 'btn btn-primary');
        $('#modal_ok_link').html("Yes");
        $('#modal_ok_link').attr("href", "javascript:window.location = \"<?= base_url(); ?>/po/view/<?= @$po->id; ?>?approving=1\";");
        $('#modal-form').modal();
    }

    function authorizing() {
        $('#modal_title').html('Approving PO');
        $('#modal_message').html("Are you sure want to authorize this PO?");
        $('#modal_type').attr("class", 'modal-content');
        $('#modal_ok_link').attr("class", 'btn btn-primary');
        $('#modal_ok_link').html("Yes");
        $('#modal_ok_link').attr("href", "javascript:window.location = \"<?= base_url(); ?>/po/view/<?= @$po->id; ?>?authorizing=1\";");
        $('#modal-form').modal();
    }

    function calculate() {
        var subtotal = 0;
        var ii = -1;
        var disc = $("[name='disc']").val() * 1;
        var is_tax = $("[name='is_tax']").val() * 1;
        $("#po_details_body").find('input[name="price[]"]').each(function() {
            ii++;
            var qty = $("#po_details_body").find('input[name="qty[]"]')[ii].value * 1;
            var price = $(this).val() * 1;
            subtotal = subtotal + (price * qty);
        });
        var discount = subtotal * disc / 100;
        var after_disc = subtotal - discount;
        var tax = after_disc / 10 * is_tax;
        var total = after_disc + tax;
        $("[name='subtotal']").val(subtotal);
        $("[name='discount']").val(discount);
        $("[name='after_disc']").val(after_disc);
        $("[name='tax']").val(tax);
        $("[name='total']").val(total);
    }
</script>