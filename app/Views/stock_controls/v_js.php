<script>
    $("#add-row").click(function() {
        var in_out = "<select class='form-control' name='in_out[]'>";
        in_out += "<option value='in'>In</option>";
        in_out += "<option value='out'>Out</option>";
        in_out += "</select>";
        var item_history_type = "<select class='form-control' name='item_history_type_id[]'>";
        item_history_type += "<option value=''></option>";
        <?php foreach ($item_history_types as $item_history_type) : ?>
            item_history_type += "<option value='<?= $item_history_type->id; ?>'><?= $item_history_type->name; ?></option>";
        <?php endforeach ?>
        item_history_type += "</select>";
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
        var dok_no = "<input class='form-control text-right' name='dok_no[]' style='width:200px;'>";
        var sku = "<input type='text' class='form-control' name='sku[]' style='width:100px;'>";
        var qty = "<input class='form-control text-right' type='number' step='0.01' name='qty[]' style='width:100px;'>";
        var notes = "<input type='text' class='form-control' name='notes[]'>";
        var markup = "<tr>";
        markup += "<td><a class='btn btn-default' onclick = \" $(this).parents('tr').remove();\"> <i class = 'fas fa-trash-alt'> </i></a></td>";
        markup += "<td>" + in_out + "</td>";
        markup += "<td>" + item_history_type + "</td>";
        markup += "<td>" + dok_no + "</td>";
        markup += "<td>" + item + "</td>";
        markup += "<td>" + sku + "</td>";
        markup += "<td>" + qty + "</td>";
        markup += "<td>" + unit + "</td>";
        markup += "<td>" + notes + "</td>";
        markup += "</tr>";
        $("#stock_control_details_body").append(markup);
        for (var ii = 0; ii < $("#stock_control_details_body").find('input[name="item_id[]"]').length; ii++) {
            $("#stock_control_details_body").find('input[name="item_id[]"]')[ii].id = "item_id[" + ii + "]";
            $("#stock_control_details_body").find('input[name="item_name[]"]')[ii].id = "item_name[" + ii + "]";
        }

    });
    <?php if (isset($stock_control)) : ?>
        $("[name='stock_control_no']").val("<?= $stock_control->stock_control_no; ?>");
        $("[name='stock_control_at']").val("<?= $stock_control->stock_control_at; ?>");
        $("[name='description']").val("<?= $stock_control->description; ?>");
    <?php else : ?>
        $("[name='stock_control_no']").val("<?= $stock_control_no ?>");
        $("[name='stock_control_at']").val("<?= date("Y-m-d"); ?>");
    <?php endif ?>
    <?php if (isset($stock_control_details) && count($stock_control_details) > 0) : ?>
        <?php foreach ($stock_control_details as $key => $stock_control_detail) : ?>
            $("#add-row").click();
            $("#stock_control_details_body").find('select[name="in_out[]"]')[<?= $key; ?>].value = "<?= @$stock_control_detail->in_out; ?>";
            $("#stock_control_details_body").find('select[name="item_history_type_id[]"]')[<?= $key; ?>].value = "<?= @$stock_control_detail->item_history_type_id; ?>";
            $("#stock_control_details_body").find('input[name="dok_no[]"]')[<?= $key; ?>].value = "<?= @$stock_control_detail->dok_no; ?>";
            $("#stock_control_details_body").find('input[name="item_id[]"]')[<?= $key; ?>].value = "<?= @$stock_control_detail->item_id; ?>";
            $("#stock_control_details_body").find('input[name="item_name[]"]')[<?= $key; ?>].value = "<?= @$stock_control_detail_item[$stock_control_detail->item_id]->name; ?>";
            $("#stock_control_details_body").find('input[name="sku[]"]')[<?= $key; ?>].value = "<?= @$stock_control_detail->sku; ?>";
            $("#stock_control_details_body").find('input[name="qty[]"]')[<?= $key; ?>].value = "<?= @$stock_control_detail->qty; ?>";
            $("#stock_control_details_body").find('select[name="unit_id[]"]')[<?= $key; ?>].value = "<?= @$stock_control_detail->unit_id; ?>";
            $("#stock_control_details_body").find('input[name="notes[]"]')[<?= $key; ?>].value = "<?= @$stock_control_detail->notes; ?>";
        <?php endforeach ?>
    <?php endif ?>

    function approving() {
        $('#modal_title').html('Approving Stock Control');
        $('#modal_message').html("Are you sure want to approve this Stock Control?");
        $('#modal_type').attr("class", 'modal-content');
        $('#modal_ok_link').attr("class", 'btn btn-primary');
        $('#modal_ok_link').html("Yes");
        $('#modal_ok_link').attr("href", "javascript:window.location = \"<?= base_url(); ?>/stock_control/view/<?= @$stock_control->id; ?>?approving=1\";");
        $('#modal-form').modal();
    }
</script>