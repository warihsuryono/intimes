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
        $("#supplier_invoice_details_body").append(markup);
    });
    <?php if (isset($supplier_invoice)) : ?>
        $("[name='invoice_no']").val("<?= $supplier_invoice->invoice_no; ?>");
        $("[name='po_id']").val("<?= $supplier_invoice->po_id; ?>");
        $("[name='supplier_id']").val("<?= $supplier_invoice->supplier_id; ?>");
        $("[name='currency_id']").val("<?= $supplier_invoice->currency_id; ?>");
        $("[name='issued_at']").val("<?= $supplier_invoice->issued_at; ?>");
        $("[name='payment_type_id']").val("<?= $supplier_invoice->payment_type_id; ?>");
        $("[name='due_date']").val("<?= $supplier_invoice->due_date; ?>");
        $("[name='description']").val("<?= $supplier_invoice->description; ?>");
        $("[name='subtotal']").val("<?= $supplier_invoice->subtotal; ?>");
        $("[name='is_tax']").val("<?= $supplier_invoice->is_tax; ?>");
        $("[name='tax']").val("<?= $supplier_invoice->tax; ?>");
        $("[name='total']").val("<?= $supplier_invoice->total; ?>");
    <?php endif ?>
    <?php if (isset($supplier_invoice_details) && count($supplier_invoice_details) > 0) : ?>
        <?php foreach ($supplier_invoice_details as $key => $supplier_invoice_detail) : ?>
            $("#add-row").click();
            $("#supplier_invoice_details_body").find('select[name="item_id[]"]')[<?= $key; ?>].value = "<?= $supplier_invoice_detail->item_id; ?>";
            $("#supplier_invoice_details_body").find('select[name="unit_id[]"]')[<?= $key; ?>].value = "<?= $supplier_invoice_detail->unit_id; ?>";
            $("#supplier_invoice_details_body").find('input[name="qty[]"]')[<?= $key; ?>].value = "<?= $supplier_invoice_detail->qty; ?>";
            $("#supplier_invoice_details_body").find('input[name="price[]"]')[<?= $key; ?>].value = "<?= $supplier_invoice_detail->price; ?>";
            $("#supplier_invoice_details_body").find('input[name="notes[]"]')[<?= $key; ?>].value = "<?= $supplier_invoice_detail->notes; ?>";
        <?php endforeach ?>
        calculate();
    <?php endif ?>

    function load_po(po_id) {
        $.get("<?= base_url(); ?>/po/get_po/" + po_id, function(data) {
            var po = JSON.parse(data);
            $("[name='supplier_id']").val(po.supplier_id);
            $("[name='currency_id']").val(po.currency_id);
            $("[name='issued_at']").val("<?= date("Y-m-d"); ?>");
            $("[name='payment_type_id']").val(po.payment_type_id);
            $("[name='due_date']").val(po.due_date);
            $("[name='description']").val(po.description);
            $("[name='subtotal']").val(po.subtotal);
            $("[name='is_tax']").val(po.is_tax);
            $("[name='tax']").val(po.tax);
            $("[name='total']").val(po.total);
        });
        $.get("<?= base_url(); ?>/po/get_po_detail/" + po_id, function(data) {
            var po_details = JSON.parse(data);
            for (var ii = 0; ii < po_details.length; ii++) {
                $("#add-row").click();
                $("#supplier_invoice_details_body").find('select[name="item_id[]"]')[ii].value = po_details[ii].item_id;
                $("#supplier_invoice_details_body").find('select[name="unit_id[]"]')[ii].value = po_details[ii].unit_id;
                $("#supplier_invoice_details_body").find('input[name="qty[]"]')[ii].value = po_details[ii].qty;
                $("#supplier_invoice_details_body").find('input[name="price[]"]')[ii].value = po_details[ii].price;
                $("#supplier_invoice_details_body").find('input[name="notes[]"]')[ii].value = po_details[ii].notes;
            }
        });
    }

    function calculate() {
        var subtotal = 0;
        var ii = -1;
        var is_tax = $("[name='is_tax']").val() * 1;
        $("#supplier_invoice_details_body").find('input[name="price[]"]').each(function() {
            ii++;
            var qty = $("#supplier_invoice_details_body").find('input[name="qty[]"]')[ii].value * 1;
            var price = $(this).val() * 1;
            subtotal = subtotal + (price * qty);
        });
        var tax = subtotal / 10 * is_tax;
        var total = subtotal + tax;
        $("[name='subtotal']").val(subtotal);
        $("[name='tax']").val(tax);
        $("[name='total']").val(total);
    }
</script>