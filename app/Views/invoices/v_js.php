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
        $("#invoice_details_body").append(markup);
        for (var ii = 0; ii < $("#invoice_details_body").find('input[name="item_id[]"]').length; ii++) {
            $("#invoice_details_body").find('input[name="item_id[]"]')[ii].id = "item_id[" + ii + "]";
            $("#invoice_details_body").find('input[name="item_name[]"]')[ii].id = "item_name[" + ii + "]";
        }

    });
    <?php if (isset($invoice)) : ?>
        $("[name='invoice_no']").val("<?= $invoice->invoice_no; ?>");
        $("[name='invoice_at']").val("<?= $invoice->invoice_at; ?>");
        $("[name='so_id']").val("<?= $invoice->so_id; ?>");
        $("[name='so_no']").val("<?= $invoice->so_no; ?>");
        $("[name='customer_id']").val("<?= $invoice->customer_id; ?>");
        $("[name='customer_name']").val("<?= $customer->company_name; ?>");
        $("[name='currency_id']").val("<?= $invoice->currency_id; ?>");
        $("[name='due_date']").val("<?= $invoice->due_date; ?>");
        $("[name='invoice_status_id']").val("<?= $invoice->invoice_status_id; ?>");
        $("[name='is_tax']").val("<?= $invoice->is_tax; ?>");
        $("[name='description']").val("<?= $invoice->description; ?>");
        $("[name='dp']").val("<?= $invoice->dp; ?>");
        $("[name='payment_type_id']").val("<?= $invoice->payment_type_id; ?>");
        $("[name='subtotal']").val("<?= $invoice->subtotal; ?>");
        $("[name='disc']").val("<?= $invoice->disc; ?>");
        $("[name='after_disc']").val("<?= $invoice->after_disc; ?>");
        $("[name='tax']").val("<?= $invoice->tax; ?>");
        $("[name='total']").val("<?= $invoice->total; ?>");
        $("[name='total_to_say']").val("<?= $invoice->total_to_say; ?>");
    <?php else : ?>
        $("[name='invoice_no']").val("<?= $invoice_no ?>");
        $("[name='invoice_at']").val("<?= date("Y-m-d"); ?>");
        $("[name='due_date']").val("30");
    <?php endif ?>
    <?php if (isset($invoice_details) && count($invoice_details) > 0) : ?>
        <?php foreach ($invoice_details as $key => $invoice_detail) : ?>
            $("#add-row").click();
            $("#invoice_details_body").find('input[name="item_id[]"]')[<?= $key; ?>].value = "<?= @$invoice_detail->item_id; ?>";
            $("#invoice_details_body").find('input[name="item_name[]"]')[<?= $key; ?>].value = "<?= @$invoice_detail_item[$invoice_detail->item_id]->name; ?>";
            $("#invoice_details_body").find('select[name="unit_id[]"]')[<?= $key; ?>].value = "<?= @$invoice_detail->unit_id; ?>";
            $("#invoice_details_body").find('input[name="qty[]"]')[<?= $key; ?>].value = "<?= @$invoice_detail->qty; ?>";
            $("#invoice_details_body").find('input[name="price[]"]')[<?= $key; ?>].value = "<?= @$invoice_detail->price; ?>";
            $("#invoice_details_body").find('input[name="notes[]"]')[<?= $key; ?>].value = "<?= @$invoice_detail->notes; ?>";
        <?php endforeach ?>
        calculate();
    <?php endif ?>

    function approving() {
        $('#modal_title').html('Approving Invoice');
        $('#modal_message').html("Are you sure want to approve this Invoice?");
        $('#modal_type').attr("class", 'modal-content');
        $('#modal_ok_link').attr("class", 'btn btn-primary');
        $('#modal_ok_link').html("Yes");
        $('#modal_ok_link').attr("href", "javascript:window.location = \"<?= base_url(); ?>/invoice/view/<?= @$invoice->id; ?>?approving=1\";");
        $('#modal-form').modal();
    }

    function calculate() {
        var subtotal = 0;
        var ii = -1;
        var disc = $("[name='disc']").val() * 1;
        var is_tax = $("[name='is_tax']").val() * 1;
        $("#invoice_details_body").find('input[name="price[]"]').each(function() {
            ii++;
            var qty = $("#invoice_details_body").find('input[name="qty[]"]')[ii].value * 1;
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