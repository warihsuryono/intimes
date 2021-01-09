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
                                        <label for="quotation_no">Quotation No</label>
                                        <input type="text" class="form-control" id="quotation_no" name="quotation_no" placeholder="Quotation No ..." <?= ($__mode == "revision" || @$revisi > 0) ? "readonly" : ""; ?>>
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
                                        <label for="quotation_at">Quotation Date</label>
                                        <input type="date" class="form-control" name="quotation_at" placeholder="Quotation Date ...">
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
                                        <label for="attn">Attention</label>
                                        <input class="form-control" id="attn" name="attn" placeholder="Attn. ">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="request_no">Request Letter No</label>
                                        <input class="form-control" name="request_no" placeholder="Request Letter No ...">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="request_at">Request Letter Date</label>
                                        <input class="form-control" name="request_at" type="date" placeholder="Request Letter Date ...">
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
                                        <label for="description">Notes</label>
                                        <textarea class="form-control" name="description" placeholder="Notes ..."></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="price_notes">Price Notes</label>
                                        <input class="form-control" name="price_notes" placeholder="Price Notes ...">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="payment_notes">Payment Notes</label>
                                        <input class="form-control" name="payment_notes" placeholder="Payment Notes ...">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="execution_time">Execution Time</label>
                                        <input class="form-control" name="execution_time" placeholder="Execution Time ...">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="execution_at">Execution At</label>
                                        <input class="form-control" name="execution_at" placeholder="Execution At ...">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="validation_notes">Validation</label>
                                        <input class="form-control" name="validation_notes" placeholder="Validation ...">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="disc">Disc (%)</label>
                                        <input class="form-control text-right" name="disc" placeholder="Disc (%) ..." onkeyup="calculate()">
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
                                            <input class="form-control text-right" name="subtotal" readonly>
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
                                            <input class="form-control text-right" name="discount" readonly>
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
                                            <input class="form-control text-right" name="after_disc" readonly>
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
                                            <input class="form-control text-right" name="tax" readonly>
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
                                            <input class="form-control text-right" name="total" readonly>
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
                                            <th>Type</th>
                                            <th>Scope</th>
                                            <th>Unit</th>
                                            <th>Qty</th>
                                            <th>Price</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody id="quotation_details_body"></tbody>
                                </table>
                            </div>
                            <div class=" card-footer">
                                <a href="<?= base_url(); ?>/quotation" class="btn btn-info">Back</a>
                                <?php if ($__mode != "add") : ?>
                                    <a href="<?= base_url(); ?>/quotation/view/<?= $quotation->id; ?>" class="btn btn-info"><i class="fas fa-eye"></i> View</a>
                                <?php endif ?>
                                <input type="hidden" name="Save" value="save">
                                <input type="button" name="btnSave" value="save" class="btn btn-primary float-right" onclick="if(before_submit()){submit();}">
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
            $.get("<?= base_url(); ?>/customer/get_customer/" + id, function(result) {
                console.log(result);
                var customers = JSON.parse(result);
                if (customers[0].pic == "")
                    document.getElementById("attn").value = "";
                else
                    document.getElementById("attn").value = "Attn. " + customers[0].pic;
            });
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

    function reload_pr(pr_no) {
        $.get("<?= base_url(); ?>/pr/get_pr/" + pr_no, function(result) {
            var pr = JSON.parse(result.replace("[", "").replace("]", ""));
            $("[name='description']").val(pr.description);

            $.get("<?= base_url(); ?>/pr/get_pr_detail/" + pr.id, function(result_detail) {
                $("#quotation_details_body").html("");
                var pr_detail = JSON.parse(result_detail);
                for (var ii = 0; ii < pr_detail.length; ii++) {
                    $("#add-row").click();
                    $("#quotation_details_body").find('input[name="item_id[]"]')[ii].value = pr_detail[ii].item_id;
                    $("#quotation_details_body").find('input[name="item_name[]"]')[ii].value = pr_detail[ii].item_name;
                    $("#quotation_details_body").find('select[name="unit_id[]"]')[ii].value = pr_detail[ii].unit_id;
                    $("#quotation_details_body").find('input[name="qty[]"]')[ii].value = pr_detail[ii].qty;
                    $("#quotation_details_body").find('input[name="notes[]"]')[ii].value = pr_detail[ii].notes;
                }
            });
        });
    }
    <?php if (isset($_SESSION["reload_pr"]) && $_SESSION["reload_pr"] != "") : ?>
        setTimeout(function() {
            $(document).ready(function() {
                reload_pr("<?= $_SESSION["reload_pr"]; ?>");
                $("#pr_no").val("<?= $_SESSION["reload_pr"]; ?>");
            });
        }, 1000);
    <?php endif ?>
</script>