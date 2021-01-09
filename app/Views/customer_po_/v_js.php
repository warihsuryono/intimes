<script>
    $("#add-row").click(function() {
        var item = "<select class='form-control' name='item_id[]'>";
        <?php foreach ($items as $item) : ?>
            item += "<option value='<?= $item->id; ?>'><?= $item->name; ?></option>";
        <?php endforeach ?>
        item += "</select>";
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
        $("#customer_po_details_body").append(markup);
    });
    <?php if (isset($customer_po)) : ?>
        $("[name='po_no']").val("<?= $customer_po->po_no; ?>");
        $("[name='quotation_no']").val("<?= $customer_po->quotation_no; ?>");
        $("[name='customer_id']").val("<?= $customer_po->customer_id; ?>");
        $("[name='currency_id']").val("<?= $customer_po->currency_id; ?>");
        $("[name='is_tax']").val("<?= $customer_po->is_tax; ?>");
        $("[name='po_received_at']").val("<?= $customer_po->po_received_at; ?>");
        $("[name='description']").val("<?= $customer_po->description; ?>");
        $("[name='shipment_pic']").val("<?= $customer_po->shipment_pic; ?>");
        $("[name='shipment_phone']").val("<?= $customer_po->shipment_phone; ?>");
        $("[name='shipment_address']").val("<?= $customer_po->shipment_address; ?>");
        $("[name='shipment_at']").val("<?= $customer_po->shipment_at; ?>");
        $("[name='dp']").val("<?= $customer_po->dp; ?>");
        $("[name='payment_type_id']").val("<?= $customer_po->payment_type_id; ?>");
        $("[name='subtotal']").val("<?= $customer_po->subtotal; ?>");
        $("[name='disc']").val("<?= $customer_po->disc; ?>");
        $("[name='after_disc']").val("<?= $customer_po->after_disc; ?>");
        $("[name='tax']").val("<?= $customer_po->tax; ?>");
        $("[name='total']").val("<?= $customer_po->total; ?>");
    <?php endif ?>
    <?php if (isset($customer_po_details) && count($customer_po_details) > 0) : ?>
        <?php foreach ($customer_po_details as $key => $customer_po_detail) : ?>
            $("#add-row").click();
            $("#customer_po_details_body").find('select[name="item_id[]"]')[<?= $key; ?>].value = "<?= $customer_po_detail->item_id; ?>";
            $("#customer_po_details_body").find('select[name="unit_id[]"]')[<?= $key; ?>].value = "<?= $customer_po_detail->unit_id; ?>";
            $("#customer_po_details_body").find('input[name="qty[]"]')[<?= $key; ?>].value = "<?= $customer_po_detail->qty; ?>";
            $("#customer_po_details_body").find('input[name="price[]"]')[<?= $key; ?>].value = "<?= $customer_po_detail->price; ?>";
            $("#customer_po_details_body").find('input[name="notes[]"]')[<?= $key; ?>].value = "<?= $customer_po_detail->notes; ?>";
        <?php endforeach ?>
        calculate();
    <?php endif ?>

    function calculate() {
        var subtotal = 0;
        var ii = -1;
        var disc = $("[name='disc']").val() * 1;
        var is_tax = $("[name='is_tax']").val() * 1;
        $("#customer_po_details_body").find('input[name="price[]"]').each(function() {
            ii++;
            var qty = $("#customer_po_details_body").find('input[name="qty[]"]')[ii].value * 1;
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