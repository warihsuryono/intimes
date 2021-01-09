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
                                        <label for="so_no">Sales Order No</label>
                                        <input type="text" class="form-control" id="so_no" name="so_no" placeholder="Sales Order No ..." onblur="reload_so(this.value);" <?= ($__mode == "revision" || @$revisi > 0) ? "readonly" : ""; ?>>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="invoice_no">Invoice Number</label>
                                        <input type="text" class="form-control" name="invoice_no" placeholder="Invoice Number ..." <?= ($__mode == "revision" || @$revisi > 0) ? "readonly" : ""; ?>>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="invoice_at">Invoice Date</label>
                                        <input type="date" class="form-control" name="invoice_at" placeholder="Invoice Date ...">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="customer_id">Customer</label>
                                    <div class="input-group">
                                        <input type="hidden" id="customer_id" name="customer_id">
                                        <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Customer Name" readonly>
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-info btn-flat" onclick="browse_customers('customer_id','customer_name');"><i class="fas fa-search"></i></button>
                                        </span>
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
                                        <label for="is_tax">is Tax</label>
                                        <select name="is_tax" class="form-control" onchange="calculate()">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="dp">Due Date (days)</label>
                                        <input type="number" step="1" class="form-control text-right" name="due_date" placeholder="Due Date ...">
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
                                    <tbody id="invoice_details_body"></tbody>
                                </table>
                            </div>
                            <div class=" card-footer">
                                <a href="<?= base_url(); ?>/invoices" class="btn btn-info">Back</a>
                                <?php if ($__mode != "add") : ?>
                                    <a href="<?= base_url(); ?>/invoice/view/<?= $invoice->id; ?>" class="btn btn-info"><i class="fas fa-eye"></i> View</a>
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


    function subwindow_customer_selected(idx, id, name) {
        try {
            document.getElementById("customer_id").value = id;
            document.getElementById("customer_name").value = name;
        } catch (e) {}
        $('#modal-form').modal('toggle');
    }

    function reload_subwindow_customers_area(keyword) {
        keyword = keyword || "";
        $.get("<?= base_url(); ?>/subwindow/customers?keyword=" + keyword, function(result) {
            $('#subwindow_list_area').html(result);
        });
    }

    function browse_customers() {
        var content = "<div class=\"row\">";
        content += "    <div class=\"col-12\">";
        content += "        <div class=\"form-group\">";
        content += "            <label>Search:</label>";
        content += "            <input name=\"keyword\" type=\"text\" class=\"form-control\" onkeyup=\"reload_subwindow_customers_area(this.value);\">";
        content += "        </div>";
        content += "    </div>";
        content += "</div>";
        content += "<div id=\"subwindow_list_area\"></div>";

        $('#modal_title').html('Customers');
        $('#modal_message').html(content);
        $('#modal_type').attr("class", 'modal-content');
        $('#modal_ok_link').attr("class", 'btn btn-danger');
        $('#modal_ok_link').html("Close");
        $('#modal_ok_link').attr("href", 'javascript:$(\'#modal-form\').modal(\'toggle\');');
        $('#modal-form').modal();
        reload_subwindow_customers_area("");
    }

    function reload_so(so_no) {
        $.get("<?= base_url(); ?>/so/get_so/" + so_no, function(result) {
            var so = JSON.parse(result.replace("[", "").replace("]", ""));
            $("[name='customer_id']").val(so.customer_id);
            $("[name='customer_name']").val(so.customer_name);
            $("[name='currency_id']").val(so.currency_id);
            $("[name='is_tax']").val(so.is_tax);
            $("[name='payment_type_id']").val(so.payment_type_id);
            $("[name='description']").val(so.description);
            $("[name='dp']").val(so.dp);
            $("[name='disc']").val(so.disc);

            $.get("<?= base_url(); ?>/so/get_so_detail/" + so.id, function(result_detail) {
                $("#invoice_details_body").html("");
                var so_detail = JSON.parse(result_detail);
                for (var ii = 0; ii < so_detail.length; ii++) {
                    $("#add-row").click();
                    $("#invoice_details_body").find('input[name="item_id[]"]')[ii].value = so_detail[ii].item_id;
                    $("#invoice_details_body").find('input[name="item_name[]"]')[ii].value = so_detail[ii].item_name;
                    $("#invoice_details_body").find('select[name="unit_id[]"]')[ii].value = so_detail[ii].unit_id;
                    $("#invoice_details_body").find('input[name="qty[]"]')[ii].value = so_detail[ii].qty;
                    $("#invoice_details_body").find('input[name="price[]"]')[ii].value = so_detail[ii].price;
                    $("#invoice_details_body").find('input[name="notes[]"]')[ii].value = so_detail[ii].notes;
                }
                setTimeout(function() {
                    calculate();
                }, 1000);
            });
        });
    }
    <?php if (isset($_SESSION["reload_so"]) && $_SESSION["reload_so"] != "") : ?>
        setTimeout(function() {
            $( document ).ready(function() {
                reload_so("<?= $_SESSION["reload_so"]; ?>");
                $("#so_no").val("<?= $_SESSION["reload_so"]; ?>");
            });
        }, 1000);
    <?php endif ?>
</script>