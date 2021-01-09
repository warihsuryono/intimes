<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <form role="form" method="POST">
                        <input type="hidden" name="mode" value="<?= $__mode; ?>">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="stock_control_no">Stock Control Number</label>
                                        <input type="text" class="form-control" name="stock_control_no" placeholder="Stock Control Number ..." readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="stock_control_at">Stock Control Date</label>
                                        <input type="date" class="form-control" name="stock_control_at" placeholder="Stock Control Date ...">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="description">Notes</label>
                                        <textarea class="form-control" name="description" placeholder="Notes ..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body table-responsive p-0" style="height: 400px;">
                                <table class="table table-head-fixed text-nowrap table-striped">
                                    <thead>
                                        <tr>
                                            <th><a class="btn btn-primary" id="add-row"><i class="fa fa-plus"></i></a></th>
                                            <th>In/Out</th>
                                            <th>Type</th>
                                            <th>Dok No</th>
                                            <th>Unit</th>
                                            <th>SKU</th>
                                            <th>Qty</th>
                                            <th>Unit</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody id="stock_control_details_body"></tbody>
                                </table>
                            </div>
                            <div class=" card-footer">
                                <a href="<?= base_url(); ?>/stock_controls" class="btn btn-info">Back</a>
                                <?php if ($__mode != "add") : ?>
                                    <a href="<?= base_url(); ?>/stock_control/view/<?= @$stock_control->id; ?>" class="btn btn-info"><i class="fas fa-eye"></i> View</a>
                                <?php endif ?>
                                <button type="submit" name="Save" value="save" class="btn btn-primary float-right">Save</button>
                            </div>
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
            document.getElementById("item_id[" + idx + "]").value = id;
            document.getElementById("item_name[" + idx + "]").value = name;
        } catch (e) {}
        try {
            document.getElementById("item_type[" + idx + "]").innerHTML = item_type;
        } catch (e) {}
        try {
            load_scopes(id, idx, item_scope_selected.split(","));
        } catch (e) {}
        try {
            document.getElementById("unit_id[" + idx + "]").value = unit_id;
            document.getElementById("qty[" + idx + "]").value = "1";
            document.getElementById("price[" + idx + "]").value = number_format(item_price);
        } catch (e) {}
        $('#modal-form').modal('toggle');
        calculate();
    }

    function reload_subwindow_items_area(idx, keyword) {
        keyword = keyword || "";
        $.get("<?= base_url(); ?>/subwindow/items?idx=" + idx + "&keyword=" + keyword, function(result) {
            $('#subwindow_list_area').html(result);
        });
    }

    function browse_items(elm) {
        var idx = elm.parentElement.parentElement.childNodes[1].id.replace("item_id[", "").replace("]", "");
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