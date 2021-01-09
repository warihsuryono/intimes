<script>
    function subwindow_item_selected(idx, id, name, item_type, item_scope_selected, item_price, unit_id) {
        try {
            document.getElementById("costing_item_id[" + idx + "]").value = id;
            document.getElementById("item_name[" + idx + "]").value = name;
        } catch (e) {}
        try {
            document.getElementById("item_type[" + idx + "]").innerHTML = item_type;
        } catch (e) {}
        try {
            load_scopes(id, idx);
        } catch (e) {}
        $.get("<?= base_url(); ?>/item/get_item/" + id, function(result_items) {
            var items = JSON.parse(result_items);
            document.getElementById("code[" + idx + "]").value = items[0].code;
            document.getElementById("item_specification_id[" + idx + "]").value = items[0].item_specification_id;
            document.getElementById("item_category_id[" + idx + "]").value = items[0].item_category_id;
            document.getElementById("item_sub_category_id[" + idx + "]").value = items[0].item_sub_category_id;
            document.getElementById("item_type_id[" + idx + "]").value = items[0].item_type_id;
            document.getElementById("item_scope_ids[" + idx + "]").value = items[0].item_scope_ids;
        });
        $('#modal-form').modal('toggle');
    }

    function reload_subwindow_items_area(idx, keyword) {
        keyword = keyword || "";
        $.get("<?= base_url(); ?>/subwindow/items?idx=" + idx + "&keyword=" + keyword, function(result) {
            $('#subwindow_list_area').html(result);
        });
    }

    function browse_items(elm) {
        var idx = elm.parentElement.parentElement.childNodes[1].id.replace("costing_item_id[", "").replace("]", "");
        var content = "<div class=\"row\">";
        content += "    <div class=\"col-12\">";
        content += "        <div class=\"form-group\">";
        content += "            <label>Search:</label>";
        content += "            <input name=\"keyword\" type=\"text\" class=\"form-control\" onkeyup=\"reload_subwindow_items_area('" + idx + "', this.value);\">";
        content += "        </div>";
        content += "    </div>";
        content += "</div>";
        content += "<div id=\"subwindow_list_area\"></div>";

        $('#modal_title').html('Items');
        $('#modal_message').html(content);
        $('#modal_type').attr("class", 'modal-content');
        $('#modal_ok_link').attr("class", 'btn btn-danger');
        $('#modal_ok_link').html("Close");
        $('#modal_ok_link').attr("href", 'javascript:$(\'#modal-form\').modal(\'toggle\');');
        $('#modal-form').modal();
        reload_subwindow_items_area(idx, "");
    }

    function load_scopes(costing_item_id, idx, selected) {
        selected = selected || [];
        var elm_item_scope_ids = $("#item_costing_body").find('select[id="item_scope_ids[' + idx + ']"]');
        elm_item_scope_ids.html("<option value=''>Loading, please wait ...</option>");
        elm_item_scope_ids.multiselect('rebuild');
        $.get("<?= base_url(); ?>/item_scope/scopes_by_item_id/" + costing_item_id, function(result) {
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

    function before_submit() {
        for (var ii = 0; ii < $("#item_costing_body").find('input[name="costing_item_id[]"]').length; ii++) {
            document.getElementById("item_scope_ids[" + ii + "]").name = "item_scope_ids[" + ii + "][]";
        }
        return true;
    }

    $("#add-row").click(function() {

        var item = "<label for=\"code\">Item</label>";
        item += "<div class=\"input-group\">";
        item += "   <input type=\"text\" id=\"costing_item_id[]\" name=\"costing_item_id[]\" readonly>";
        item += "   <span class=\"input-group-btn\">";
        item += "       <button type=\"button\" class=\"btn btn-info btn-flat\" onclick=\"browse_items(this);\"><i class=\"fas fa-search\"></i></button>";
        item += "   </span>";
        item += "</div>";
        var item_name = "<div class=\"form-group\">";
        item_name += "<label>Name</label>";
        item_name += "<input type=\"text\" class=\"form-control\" id=\"item_name[]\" name=\"item_name[]\" placeholder=\"Item Name\">";
        item_name += "</div>";


        var code = "<div class=\"form-group\">";
        code += "<label>Code</label>";
        code += "<input type=\"text\" class=\"form-control\" id=\"code[]\" name=\"code[]\" placeholder=\"Code\">";
        code += "</div>";

        var specification = "<label>Specification</label>";
        specification += "<select class='form-control' name='item_specification_id[]'>";
        specification += "<option value=''></option>";
        <?php foreach ($item_specifications as $item_specification) : ?>
            specification += "<option value='<?= $item_specification->id; ?>'><?= $item_specification->name; ?></option>";
        <?php endforeach ?>
        specification += "</select>";

        var category = "<label>Category</label>";
        category += "<select class='form-control' name='item_category_id[]'>";
        category += "<option value=''></option>";
        <?php foreach ($item_categories as $item_category) : ?>
            category += "<option value='<?= $item_category->id; ?>'><?= $item_category->name; ?></option>";
        <?php endforeach ?>
        category += "</select>";

        var sub_category = "<label>Sub Category</label>";
        sub_category += "<select class='form-control' name='item_sub_category_id[]'>";
        sub_category += "<option value=''></option>";
        <?php foreach ($item_sub_categories as $item_sub_category) : ?>
            sub_category += "<option value='<?= $item_sub_category->id; ?>'><?= $item_sub_category->name; ?></option>";
        <?php endforeach ?>
        sub_category += "</select>";

        var type = "<label>Type</label>";
        type += "<select class='form-control' name='item_type_id[]'>";
        type += "<option value=''></option>";
        <?php foreach ($item_types as $item_type) : ?>
            type += "<option value='<?= $item_type->id; ?>'><?= $item_type->name; ?></option>";
        <?php endforeach ?>
        type += "</select>";

        var scope = "<div class=\"form-group\">";
        scope += "<label>Scope/Range</label><br>";
        scope += "<select name=\"item_scope_ids[]\" class=\"form-control\" multiple=\"multiple\"></select>";
        scope += "<input type=\"hidden\" name=\"item_scope_ids[]\">";
        scope += "</div>";

        var volume_budget = "<label>Volume Budget</label>";
        volume_budget += "<div class=\"input-group\">";
        volume_budget += "<input type=\"text\" name=\"volume_budget[]\" class=\"form-control\" placeholder=\"Volume Budget\">";
        volume_budget += "   <span class=\"input-group-select\">";
        volume_budget += "       <select id=\"volume_unit_id[]\" name=\"volume_unit_id[]\" class=\"form-control\">";
        <?php foreach ($units as $unit) : ?>
            volume_budget += "           <option value=\"<?= $unit->id; ?>\"><?= $unit->name; ?></option>";
        <?php endforeach ?>
        volume_budget += "       </select>";
        volume_budget += "   </span>";
        volume_budget += "</div>";

        var cost_budget = "<label>Cost Budget</label>";
        cost_budget += "<div class=\"input-group\">";
        cost_budget += "   <span class=\"input-group-select\">";
        cost_budget += "       <select id=\"cost_currency_id[]\" name=\"cost_currency_id[]\" class=\"form-control\">";
        <?php foreach ($currencies as $currency) : ?>
            cost_budget += "           <option value=\"<?= $currency->id; ?>\"><?= $currency->id; ?></option>";
        <?php endforeach ?>
        cost_budget += "       </select>";
        cost_budget += "   </span>";
        cost_budget += "<input type=\"text\" name=\"cost_budget[]\" class=\"form-control\" placeholder=\"Cost Budget\">";
        cost_budget += "</div>";

        var revenue = "<label>Revenue</label>";
        revenue += "<div class=\"input-group\">";
        revenue += "   <span class=\"input-group-select\">";
        revenue += "       <select id=\"revenue_currency_id[]\" name=\"revenue_currency_id[]\" class=\"form-control\">";
        <?php foreach ($currencies as $currency) : ?>
            revenue += "           <option value=\"<?= $currency->id; ?>\"><?= $currency->id; ?></option>";
        <?php endforeach ?>
        revenue += "       </select>";
        revenue += "   </span>";
        revenue += "<input type=\"text\" name=\"revenue[]\" class=\"form-control\" placeholder=\"Revenue\">";
        revenue += "</div>";

        var markup = "<span>";
        markup += "<div style='border:2px solid black;margin-top:10px;margin-bottom:10px;'></div>";
        markup += "<div class=\"col-sm-12\"><a class='btn btn-default' onclick = \"$(this).parents('span').remove();\"> <i class = 'fas fa-trash-alt'> </i></a></div>";
        markup += "<div class=\"row\">";
        markup += "";
        markup += "<div class=\"col-sm-4\">" + item + "</div>";
        markup += "<div class=\"col-sm-4\">" + item_name + "</div>";
        markup += "<div class=\"col-sm-4\">" + code + "</div>";
        markup += "<div class=\"col-sm-4\">" + specification + "</div>";
        markup += "<div class=\"col-sm-4\">" + category + "</div>";
        markup += "<div class=\"col-sm-4\">" + sub_category + "</div>";
        markup += "<div class=\"col-sm-4\">" + type + "</div>";
        markup += "<div class=\"col-sm-4\">" + scope + "</div>";
        markup += "<div class=\"col-sm-4\">" + volume_budget + "</div>";
        markup += "<div class=\"col-sm-4\">" + cost_budget + "</div>";
        markup += "<div class=\"col-sm-4\">" + revenue + "</div>";
        markup += "</div>";
        markup += "</span>";
        $("#item_costing_body").append(markup);
        for (var ii = 0; ii < $("#item_costing_body").find('input[name="costing_item_id[]"]').length; ii++) {
            $("#item_costing_body").find('input[name="costing_item_id[]"]')[ii].id = "costing_item_id[" + ii + "]";
            $("#item_costing_body").find('input[name="item_name[]"]')[ii].id = "item_name[" + ii + "]";
            $("#item_costing_body").find('input[name="code[]"]')[ii].id = "code[" + ii + "]";
            $("#item_costing_body").find('select[name="item_specification_id[]"]')[ii].id = "item_specification_id[" + ii + "]";
            $("#item_costing_body").find('select[name="item_category_id[]"]')[ii].id = "item_category_id[" + ii + "]";
            $("#item_costing_body").find('select[name="item_sub_category_id[]"]')[ii].id = "item_sub_category_id[" + ii + "]";
            $("#item_costing_body").find('select[name="item_type_id[]"]')[ii].id = "item_type_id[" + ii + "]";
            $("#item_costing_body").find('select[name="item_scope_ids[]"]')[ii].id = "item_scope_ids[" + ii + "]";
            $("#item_costing_body").find('input[name="volume_budget[]"]')[ii].id = "volume_budget[" + ii + "]";
            $("#item_costing_body").find('select[name="volume_unit_id[]"]')[ii].id = "volume_unit_id[" + ii + "]";
            $("#item_costing_body").find('select[name="cost_currency_id[]"]')[ii].id = "cost_currency_id[" + ii + "]";
            $("#item_costing_body").find('input[name="cost_budget[]"]')[ii].id = "cost_budget[" + ii + "]";
            $("#item_costing_body").find('select[name="revenue_currency_id[]"]')[ii].id = "revenue_currency_id[" + ii + "]";
            $("#item_costing_body").find('input[name="revenue[]"]')[ii].id = "revenue[" + ii + "]";
            $("[id='item_scope_ids[" + ii + "]']").multiselect({
                buttonWidth: '100%',
                enableFiltering: false,
                maxHeight: 300
            });
        }

        <?php if (isset($item_costings) && count($item_costings) > 0) : ?>
            <?php foreach ($item_costings as $key => $item_costing) : ?>
                setTimeout(function() {
                    $("#item_costing_body").find('select[id="item_scope_ids[<?= $key; ?>]"]').multiselect('select', [<?= str_replace("|", "", str_replace("||", ",", $item_costing->item_scope_ids)); ?>]);
                }, 500);
            <?php endforeach ?>
        <?php endif ?>

    });

    <?php if (isset($item_costings) && count($item_costings) > 0) : ?>
        <?php foreach ($item_costings as $key => $item_costings) : ?>
            $("#add-row").click();
            $("#item_costing_body").find('input[name="costing_item_id[]"]')[<?= $key; ?>].value = "<?= @$item_costings->costing_item_id; ?>";
            $("#item_costing_body").find('input[name="item_name[]"]')[<?= $key; ?>].value = "<?= @$item_costings->costing_item_id; ?>";
            $("#item_costing_body").find('input[name="code[]"]')[<?= $key; ?>].value = "<?= @$item_costings->code; ?>";
            $("#item_costing_body").find('select[name="item_specification_id[]"]')[<?= $key; ?>].value = "<?= @$item_costings->item_specification_id; ?>";
            $("#item_costing_body").find('select[name="item_category_id[]"]')[<?= $key; ?>].value = "<?= @$item_costings->item_category_id; ?>";
            $("#item_costing_body").find('select[name="item_sub_category_id[]"]')[<?= $key; ?>].value = "<?= @$item_costings->item_sub_category_id; ?>";
            $("#item_costing_body").find('select[name="item_type_id[]"]')[<?= $key; ?>].value = "<?= @$item_costings->item_type_id; ?>";
            $("#item_costing_body").find('input[name="volume_budget[]"]')[<?= $key; ?>].value = "<?= @$item_costings->volume_budget; ?>";
            $("#item_costing_body").find('select[name="volume_unit_id[]"]')[<?= $key; ?>].value = "<?= @$item_costings->volume_unit_id; ?>";
            $("#item_costing_body").find('select[name="cost_currency_id[]"]')[<?= $key; ?>].value = "<?= @$item_costings->cost_currency_id; ?>";
            $("#item_costing_body").find('input[name="cost_budget[]"]')[<?= $key; ?>].value = "<?= @$item_costings->cost_budget; ?>";
            $("#item_costing_body").find('select[name="revenue_currency_id[]"]')[<?= $key; ?>].value = "<?= @$item_costings->revenue_currency_id; ?>";
            $("#item_costing_body").find('input[name="revenue[]"]')[<?= $key; ?>].value = "<?= @$item_costings->revenue; ?>";
            $.get("<?= base_url(); ?>/item/get_item/<?= @$item_costings->costing_item_id; ?>", function(result_items) {
                var items = JSON.parse(result_items);
                document.getElementById("item_name[<?= $key; ?>]").value = items[0].name;
            });
            setTimeout(function() {
                load_scopes("<?= @$item_costings->costing_item_id; ?>", <?= $key; ?>, [<?= str_replace("|", "", str_replace("||", ",", $item_costings->item_scope_ids)); ?>]);
            }, 500);
        <?php endforeach ?>
    <?php endif ?>
</script>