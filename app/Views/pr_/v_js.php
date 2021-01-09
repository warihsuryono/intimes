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
        var notes = "<input type='text' class='form-control' name='notes[]'>";
        var markup = "<tr>";
        markup += "<td><a class='btn btn-default' onclick = \" $(this).parents('tr').remove();\"> <i class = 'fas fa-trash-alt'> </i></a></td>";
        markup += "<td>" + item + "</td>";
        markup += "<td>" + unit + "</td>";
        markup += "<td>" + qty + "</td>";
        markup += "<td>" + notes + "</td>";
        markup += "</tr>";
        $("#pr_details_body").append(markup);
        for (var ii = 0; ii < $("#pr_details_body").find('input[name="item_id[]"]').length; ii++) {
            $("#pr_details_body").find('input[name="item_id[]"]')[ii].id = "item_id[" + ii + "]";
            $("#pr_details_body").find('input[name="item_name[]"]')[ii].id = "item_name[" + ii + "]";
        }

    });
    <?php if (isset($pr)) : ?>
        $("[name='pr_no']").val("<?= $pr->pr_no; ?>");
        $("[name='pr_at']").val("<?= $pr->pr_at; ?>");
        $("[name='description']").val("<?= $pr->description; ?>");
    <?php else : ?>
        $("[name='pr_no']").val("<?= $pr_no; ?>");
        $("[name='pr_at']").val('<?= date("Y-m-d"); ?>');
    <?php endif ?>
    <?php if (isset($pr_details) && count($pr_details) > 0) : ?>
        <?php foreach ($pr_details as $key => $pr_detail) : ?>
            $("#add-row").click();
            $("#pr_details_body").find('input[name="item_id[]"]')[<?= $key; ?>].value = "<?= @$pr_detail->item_id; ?>";
            $("#pr_details_body").find('input[name="item_name[]"]')[<?= $key; ?>].value = "<?= @$pr_detail_item[$pr_detail->item_id]->name; ?>";
            $("#pr_details_body").find('select[name="unit_id[]"]')[<?= $key; ?>].value = "<?= @$pr_detail->unit_id; ?>";
            $("#pr_details_body").find('input[name="qty[]"]')[<?= $key; ?>].value = "<?= @$pr_detail->qty; ?>";
            $("#pr_details_body").find('input[name="notes[]"]')[<?= $key; ?>].value = "<?= @$pr_detail->notes; ?>";
        <?php endforeach ?>
    <?php endif ?>
</script>