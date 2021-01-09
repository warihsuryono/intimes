<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <form role="form" method="POST">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label for="code">Item</label>
                                    <div class="input-group">
                                        <input type="text" id="item_id" name="item_id" class="form-control" readonly>
                                        <span class="input-group-btn"><button type="button" class="btn btn-info btn-flat" onclick="browse_items(this);"><i class="fas fa-search"></i></button></span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="code">Code</label>
                                        <input type="text" id="code" name="code" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="item_specification_id">Specification</label>
                                        <select id="item_specification_id" name="item_specification_id" class="form-control">
                                            <option value=""></option>
                                            <?php foreach ($item_specifications as $i_specifications) : ?>
                                                <option value="<?= $i_specifications->id; ?>"><?= $i_specifications->name; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="item_category_id">Category</label>
                                        <select id="item_category_id" name="item_category_id" class="form-control">
                                            <option value=""></option>
                                            <?php foreach ($item_categories as $i_category) : ?>
                                                <option value="<?= $i_category->id; ?>"><?= $i_category->name; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="item_sub_category_id">Sub Category</label>
                                        <select id="item_sub_category_id" name="item_sub_category_id" class="form-control">
                                            <option value=""></option>
                                            <?php foreach ($item_sub_categories as $i_sub_category) : ?>
                                                <option value="<?= $i_sub_category->id; ?>"><?= $i_sub_category->name; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="item_type_id">Type</label>
                                        <select id="item_type_id" name="item_type_id" class="form-control" onchange="load_scopes(this.value)">
                                            <option value=""></option>
                                            <?php foreach ($item_types as $i_type) : ?>
                                                <option value="<?= $i_type->id; ?>"><?= $i_type->name; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="item_scope_ids[]">Scope/Range</label><br>
                                        <select name="item_scope_ids[]" class="form-control" multiple="multiple">
                                            <?php foreach ($item_scopes as $i_scope) : ?>
                                                <option value="<?= $i_scope->id; ?>"><?= $i_scope->name; ?> <?= @$_units[$i_scope->unit_id]; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" id="item_name" name="item_name" class="form-control" placeholder="Item Name">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="name">Volume Budget</label>
                                    <div class="input-group">
                                        <input type="text" name="volume_budget" class="form-control" placeholder="Volume Budget">
                                        <span class="input-group-select">
                                            <select id="volume_unit_id" name="volume_unit_id" class="form-control">
                                                <?php foreach ($units as $unit) : ?>
                                                    <option value="<?= $unit->id; ?>"><?= $unit->name; ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="name">Cost Budget</label>
                                    <div class="input-group">
                                        <span class="input-group-select">
                                            <select name="cost_currency_id" class="form-control">
                                                <?php foreach ($currencies as $currency) : ?>
                                                    <option value="<?= $currency->id; ?>"><?= $currency->id; ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </span>
                                        <input type="text" name="cost_budget" class="form-control" placeholder="Cost Budget">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="name">Revenue</label>
                                    <div class="input-group">
                                        <span class="input-group-select">
                                            <select name="revenue_currency_id" class="form-control">
                                                <?php foreach ($currencies as $currency) : ?>
                                                    <option value="<?= $currency->id; ?>"><?= $currency->id; ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </span>
                                        <input type="text" name="revenue" class="form-control" placeholder="Revenue">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" card-footer">
                            <a href="<?= base_url(); ?>/costings" class="btn btn-info">Back</a>
                            <button type="submit" name="Save" value="save" class="btn btn-primary float-right">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function subwindow_item_selected(idx, id, name, item_type, item_scope_selected, item_price, unit_id) {
        try {
            document.getElementById("item_id").value = id;
            document.getElementById("item_name").value = name;
        } catch (e) {}
        try {
            document.getElementById("item_type").innerHTML = item_type;
        } catch (e) {}
        try {
            load_scopes(id, item_scope_selected.split(","));
        } catch (e) {}
        try {
            document.getElementById("unit_id").value = unit_id;
        } catch (e) {}
        $.get("<?= base_url(); ?>/item/get_item/" + id, function(result_items) {
            var items = JSON.parse(result_items);
            document.getElementById("code").value = items[0].code;
            document.getElementById("item_specification_id").value = items[0].item_specification_id;
            document.getElementById("item_category_id").value = items[0].item_category_id;
            document.getElementById("item_sub_category_id").value = items[0].item_sub_category_id;
            document.getElementById("item_type_id").value = items[0].item_type_id;
            document.getElementById("item_scope_ids").value = items[0].item_scope_ids;
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
        var idx = 0;
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
</script>