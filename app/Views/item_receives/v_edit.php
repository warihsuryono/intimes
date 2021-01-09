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
                                        <label for="po_no">PO No</label>
                                        <input type="text" class="form-control" id="po_no" name="po_no" placeholder="PO No ..." onblur="reload_po(this.value);" <?= ($__mode == "revision" || @$revisi > 0) ? "readonly" : ""; ?>>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="item_receive_no">Item Receive Number</label>
                                        <input type="text" class="form-control" name="item_receive_no" placeholder="Item Receive Number ..." <?= ($__mode == "revision" || @$revisi > 0) ? "readonly" : ""; ?>>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="item_receive_at">Item Receive Date</label>
                                        <input type="date" class="form-control" name="item_receive_at" placeholder="Item Receive Date ...">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="item_receive_id">Supplier</label>
                                    <div class="input-group">
                                        <input type="hidden" id="supplier_id" name="supplier_id">
                                        <input type="text" class="form-control" id="supplier_name" name="supplier_name" placeholder="Supplier Name" readonly>
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-info btn-flat" onclick="browse_suppliers('supplier_id','supplier_name');"><i class="fas fa-search"></i></button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="shipment_company">Shipment Company</label>
                                        <input type="text" class="form-control" name="shipment_company" placeholder="Shipment Company ...">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="shipment_pic">Shipment PIC</label>
                                        <input type="text" class="form-control" name="shipment_pic" placeholder="Shipment PIC ...">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="shipment_phone">Shipment Phone</label>
                                        <input type="text" class="form-control" name="shipment_phone" placeholder="Shipment Phone ...">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="shipment_address">Shipment Address</label>
                                        <textarea class="form-control" name="shipment_address" placeholder="Shipment Address ..."></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="shipment_at">Shipment At</label>
                                        <input type="date" class="form-control" name="shipment_at" placeholder="Shipment At ...">
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
                                            <th>Item</th>
                                            <th>Unit</th>
                                            <th>PO Qty</th>
                                            <th>Outstanding Qty</th>
                                            <th>Receive Qty</th>
                                            <th>SKU</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody id="item_receive_details_body"></tbody>
                                </table>
                            </div>
                            <div class=" card-footer">
                                <a href="<?= base_url(); ?>/item_receives" class="btn btn-info">Back</a>
                                <?php if ($__mode != "add") : ?>
                                    <a href="<?= base_url(); ?>/item_receive/view/<?= @$item_receive->id; ?>" class="btn btn-info"><i class="fas fa-eye"></i> View</a>
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


    function subwindow_supplier_selected(idx, id, name) {
        try {
            document.getElementById("supplier_id").value = id;
            document.getElementById("supplier_name").value = name;
        } catch (e) {}
        $('#modal-form').modal('toggle');
    }

    function reload_subwindow_suppliers_area(keyword) {
        keyword = keyword || "";
        $.get("<?= base_url(); ?>/subwindow/suppliers?keyword=" + keyword, function(result) {
            $('#subwindow_list_area').html(result);
        });
    }

    function browse_suppliers() {
        var content = "<div class=\"row\">";
        content += "    <div class=\"col-12\">";
        content += "        <div class=\"form-group\">";
        content += "            <label>Search:</label>";
        content += "            <input name=\"keyword\" type=\"text\" class=\"form-control\" onkeyup=\"reload_subwindow_suppliers_area(this.value);\">";
        content += "        </div>";
        content += "    </div>";
        content += "</div>";
        content += "<div id=\"subwindow_list_area\"></div>";

        $('#modal_title').html('Suppliers');
        $('#modal_message').html(content);
        $('#modal_type').attr("class", 'modal-content');
        $('#modal_ok_link').attr("class", 'btn btn-danger');
        $('#modal_ok_link').html("Close");
        $('#modal_ok_link').attr("href", 'javascript:$(\'#modal-form\').modal(\'toggle\');');
        $('#modal-form').modal();
        reload_subwindow_suppliers_area("");
    }

    function reload_po(po_no) {
        $.get("<?= base_url(); ?>/po/get_po/?po_no=" + po_no, function(result) {
            var po = JSON.parse(result.replace("[", "").replace("]", ""));
            $("[name='supplier_id']").val(po.supplier_id);
            $("[name='supplier_name']").val(po.supplier_name);
            $("[name='shipment_company']").val(po.shipment_company);
            $("[name='shipment_pic']").val(po.shipment_pic);
            $("[name='shipment_phone']").val(po.shipment_phone);
            $("[name='shipment_address']").val(po.shipment_address);
            $("[name='shipment_at']").val(po.shipment_at);
            $("[name='description']").val(po.description);

            $.get("<?= base_url(); ?>/po/get_po_detail/" + po.id, function(result_detail) {
                $("#item_receive_details_body").html("");
                var po_detail = JSON.parse(result_detail);
                for (var ii = 0; ii < po_detail.length; ii++) {
                    $("#add-row").click();
                    $("#item_receive_details_body").find('input[name="item_id[]"]')[ii].value = po_detail[ii].item_id;
                    $("#item_receive_details_body").find('input[name="item_name[]"]')[ii].value = po_detail[ii].item_name;
                    $("#item_receive_details_body").find('select[name="unit_id[]"]')[ii].value = po_detail[ii].unit_id;
                    $("#item_receive_details_body").find('input[name="qty_po[]"]')[ii].value = po_detail[ii].qty;
                    $("#item_receive_details_body").find('input[name="qty_outstanding[]"]')[ii].value = po_detail[ii].qty_outstanding;
                    $("#item_receive_details_body").find('input[name="qty[]"]')[ii].value = po_detail[ii].qty_outstanding;
                    $("#item_receive_details_body").find('input[name="notes[]"]')[ii].value = po_detail[ii].notes;
                }
            });
        });
    }
    <?php if (isset($_SESSION["reload_po"]) && $_SESSION["reload_po"] != "") : ?>
        setTimeout(function() {
            $( document ).ready(function() {
                reload_po("<?= $_SESSION["reload_po"]; ?>");
                $("#po_no").val("<?= $_SESSION["reload_po"]; ?>");
            });
        }, 1000);
    <?php endif ?>
</script>