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
                                        <label for="pr_no">Purchase Request No</label>
                                        <input type="text" class="form-control" id="pr_no" name="pr_no" placeholder="Purchase Request No ..." onblur="reload_pr(this.value);" <?= ($__mode == "revision" || @$revisi > 0) ? "readonly" : ""; ?>>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="po_no">PO Number</label>
                                        <input type="text" class="form-control" name="po_no" placeholder="PO Number ..." <?= ($__mode == "revision" || @$revisi > 0 || $__mode == "edit") ? "readonly" : ""; ?>>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="revisi">Revisi</label>
                                        <input type="text" class="form-control" name="revisi" placeholder="Revisi ..." readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="po_at">PO Date</label>
                                        <input type="date" class="form-control" name="po_at" placeholder="PO Date ...">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="supplier_id">Supplier</label>
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
                                        <label for="bank_notes">Bank Data</label>
                                        <textarea class="form-control" name="bank_notes" placeholder="Bank Data ..."></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="currency_id">Currency</label>
                                        <select name="currency_id" class="form-control">
                                            <?php foreach ($currencies as $currency) : ?>
                                                <option value="<?= $currency->id; ?>"><?= $currency->id; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="total_to_say_lang">Amount in words</label>
                                        <select name="total_to_say_lang" class="form-control">
                                            <option value="id">Indonesia</option>
                                            <option value="en">English</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="is_tax">is Tax</label>
                                        <select name="is_tax" class="form-control" onchange="calculate()">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="description">Notes</label>
                                        <textarea class="form-control" name="description" placeholder="Notes ..."></textarea>
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
                                        <label for="dp">Down Payment</label>
                                        <input type="number" step="0.01" class="form-control text-right" name="dp" placeholder="Down Payment ...">
                                    </div>
                                </div>
                                <div class=" col-sm-4">
                                    <div class="form-group">
                                        <label for="payment_type_id ">Payment Type</label>
                                        <select name="payment_type_id" class="form-control">
                                            <option value="">-- Payment Type --</option>
                                            <?php foreach ($payment_types as $payment_type) : ?>
                                                <option value="<?= $payment_type->id; ?>"><?= $payment_type->name; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="disc">Disc (%)</label>
                                        <input type="number" step="0.01" class="form-control text-right" name="disc" placeholder="Disc (%) ..." onkeyup="calculate()">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label>Sub Total</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="number" step="0.01" class="form-control text-right" name="subtotal" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label>Discount</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="number" step="0.01" class="form-control text-right" name="discount" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label>After Discount</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="number" step="0.01" class="form-control text-right" name="after_disc" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label>Tax</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="number" step="0.01" class="form-control text-right" name="tax" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label>TOTAL</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="number" step="0.01" class="form-control text-right" name="total" readonly>
                                        </div>
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
                                            <th>Qty</th>
                                            <th>Price</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody id="po_details_body"></tbody>
                                </table>
                            </div>
                            <div class=" card-footer">
                                <a href="<?= base_url(); ?>/po" class="btn btn-info">Back</a>
                                <?php if ($__mode != "add") : ?>
                                    <a href="<?= base_url(); ?>/po/view/<?= $po->id; ?>" class="btn btn-info"><i class="fas fa-eye"></i> View</a>
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

    function reload_pr(pr_no) {
        $.get("<?= base_url(); ?>/pr/get_pr/?pr_no=" + pr_no, function(result) {
            var pr = JSON.parse(result.replace("[", "").replace("]", ""));
            $("[name='description']").val(pr.description);

            $.get("<?= base_url(); ?>/pr/get_pr_detail/" + pr.id, function(result_detail) {
                $("#po_details_body").html("");
                var pr_detail = JSON.parse(result_detail);
                for (var ii = 0; ii < pr_detail.length; ii++) {
                    $("#add-row").click();
                    $("#po_details_body").find('input[name="item_id[]"]')[ii].value = pr_detail[ii].item_id;
                    $("#po_details_body").find('input[name="item_name[]"]')[ii].value = pr_detail[ii].item_name;
                    $("#po_details_body").find('select[name="unit_id[]"]')[ii].value = pr_detail[ii].unit_id;
                    $("#po_details_body").find('input[name="qty[]"]')[ii].value = pr_detail[ii].qty;
                    $("#po_details_body").find('input[name="notes[]"]')[ii].value = pr_detail[ii].notes;
                }
            });
        });
    }
    <?php if (isset($_SESSION["reload_pr"]) && $_SESSION["reload_pr"] != "") : ?>
        setTimeout(function() {
            $( document ).ready(function() {
                reload_pr("<?= urlencode($_SESSION["reload_pr"]); ?>");
                $("#pr_no").val("<?= $_SESSION["reload_pr"]; ?>");
            });
        }, 1000);
    <?php endif ?>
</script>