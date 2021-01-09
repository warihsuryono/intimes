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
        var qty_po = "<input class='form-control text-right' name='qty_po[]' style='width:100px;' readonly>";
        var qty_outstanding = "<input class='form-control text-right' name='qty_outstanding[]' style='width:100px;' readonly>";
        var qty = "<input class='form-control text-right' type='number' step='0.01' name='qty[]' style='width:100px;'>";
        var sku = "<input type='text' class='form-control' name='sku[]' style='width:200px;'>";
        var notes = "<input type='text' class='form-control' name='notes[]'>";
        var markup = "<tr>";
        markup += "<td><a class='btn btn-default' onclick = \" $(this).parents('tr').remove();\"> <i class = 'fas fa-trash-alt'> </i></a></td>";
        markup += "<td>" + item + "</td>";
        markup += "<td>" + unit + "</td>";
        markup += "<td>" + qty_po + "</td>";
        markup += "<td>" + qty_outstanding + "</td>";
        markup += "<td>" + qty + "</td>";
        markup += "<td>" + sku + "</td>";
        markup += "<td>" + notes + "</td>";
        markup += "</tr>";
        $("#item_receive_details_body").append(markup);
        for (var ii = 0; ii < $("#item_receive_details_body").find('input[name="item_id[]"]').length; ii++) {
            $("#item_receive_details_body").find('input[name="item_id[]"]')[ii].id = "item_id[" + ii + "]";
            $("#item_receive_details_body").find('input[name="item_name[]"]')[ii].id = "item_name[" + ii + "]";
        }

    });
    <?php if (isset($item_receive)) : ?>
        $("[name='item_receive_no']").val("<?= $item_receive->item_receive_no; ?>");
        $("[name='item_receive_at']").val("<?= $item_receive->item_receive_at; ?>");
        $("[name='po_id']").val("<?= $item_receive->po_id; ?>");
        $("[name='po_no']").val("<?= $item_receive->po_no; ?>");
        $("[name='supplier_id']").val("<?= $item_receive->supplier_id; ?>");
        $("[name='supplier_name']").val("<?= $supplier->company_name; ?>");
        $("[name='shipment_company']").val("<?= $item_receive->shipment_company; ?>");
        $("[name='shipment_pic']").val("<?= $item_receive->shipment_pic; ?>");
        $("[name='shipment_phone']").val("<?= $item_receive->shipment_phone; ?>");
        $("[name='shipment_address']").val("<?= str_replace(chr(13) . chr(10), "<br>", $item_receive->shipment_address); ?>".replace("<br>", "\n").replace("<br>", "\n").replace("<br>", "\n").replace("<br>", "\n").replace("<br>", "\n"));
        $("[name='shipment_at']").val("<?= $item_receive->shipment_at; ?>");
        $("[name='description']").val("<?= $item_receive->description; ?>");
    <?php else : ?>
        $("[name='item_receive_no']").val("<?= $item_receive_no ?>");
        $("[name='item_receive_at']").val("<?= date("Y-m-d"); ?>");
        $("[name='due_date']").val("30");
    <?php endif ?>
    <?php if (isset($item_receive_details) && count($item_receive_details) > 0) : ?>
        <?php foreach ($item_receive_details as $key => $item_receive_detail) : ?>
            $("#add-row").click();
            $("#item_receive_details_body").find('input[name="item_id[]"]')[<?= $key; ?>].value = "<?= @$item_receive_detail->item_id; ?>";
            $("#item_receive_details_body").find('input[name="item_name[]"]')[<?= $key; ?>].value = "<?= @$item_receive_detail_item[$item_receive_detail->item_id]->name; ?>";
            $("#item_receive_details_body").find('select[name="unit_id[]"]')[<?= $key; ?>].value = "<?= @$item_receive_detail->unit_id; ?>";
            $("#item_receive_details_body").find('input[name="qty_po[]"]')[<?= $key; ?>].value = "<?= @$item_receive_detail->qty_po; ?>";
            $("#item_receive_details_body").find('input[name="qty_outstanding[]"]')[<?= $key; ?>].value = "<?= @$item_receive_detail->qty_outstanding; ?>";
            $("#item_receive_details_body").find('input[name="qty[]"]')[<?= $key; ?>].value = "<?= @$item_receive_detail->qty; ?>";
            $("#item_receive_details_body").find('input[name="sku[]"]')[<?= $key; ?>].value = "<?= @$item_receive_detail->sku; ?>";
            $("#item_receive_details_body").find('input[name="notes[]"]')[<?= $key; ?>].value = "<?= @$item_receive_detail->notes; ?>";
        <?php endforeach ?>
    <?php endif ?>

    function approving() {
        $('#modal_title').html('Approving Item Receive');
        $('#modal_message').html("Are you sure want to approve this Item Receive?");
        $('#modal_type').attr("class", 'modal-content');
        $('#modal_ok_link').attr("class", 'btn btn-primary');
        $('#modal_ok_link').html("Yes");
        $('#modal_ok_link').attr("href", "javascript:window.location = \"<?= base_url(); ?>/item_receive/view/<?= @$item_receive->id; ?>?approving=1\";");
        $('#modal-form').modal();
    }
</script>