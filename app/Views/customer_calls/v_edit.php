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
                                    <label for="customer_id">Customer</label>
                                    <div class="input-group">
                                        <input type="hidden" id="customer_id" name="customer_id" value="<?= @$customer_call->customer_id; ?>">
                                        <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Customer Name" readonly value="<?= (@$customer_call->customer_name != "") ? @$customer_call->customer_name : @$customer->company_name; ?>">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-info btn-flat" onclick="browse_customers('customer_id','customer_name');"><i class="fas fa-search"></i></button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Contact Person</label>
                                        <input type="text" id="cp" name="cp" class="form-control" value="<?= @$customer_call->cp; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Contact Person Position</label>
                                        <input type="text" id="cp_position" name="cp_position" class="form-control" value="<?= @$customer_call->cp_position; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="text" id="phone" name="phone" class="form-control" value="<?= @$customer_call->phone; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" id="email" name="email" class="form-control" value="<?= @$customer_call->email; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Call At</label>
                                        <input type="datetime-local" id="call_at" name="call_at" class="form-control" value="<?= str_replace(" ", "T", @$customer_call->call_at); ?>">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Notes</label>
                                        <textarea id="notes" name="notes" class="form-control" rows="10"><?= @$customer_call->notes; ?></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Follow Up Activity</label>
                                        <select id="followup_activity" name="followup_activity" class="form-control">
                                            <option></option>
                                            <option value="Cold Call" <?= (@$customer_call->followup_activity == "Cold Call") ? "selected" : ""; ?>>Cold Call</option>
                                            <option value="Quality Call" <?= (@$customer_call->followup_activity == "Quality Call") ? "selected" : ""; ?>>Quality Call</option>
                                            <option value="Meeting" <?= (@$customer_call->followup_activity == "Meeting") ? "selected" : ""; ?>>Meeting</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Next Followup At</label>
                                        <input type="datetime-local" id="next_followup_at" name="next_followup_at" class="form-control" value="<?= str_replace(" ", "T", @$customer_call->next_followup_at); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" card-footer">
                            <a href="<?= base_url(); ?>/customer_calls" class="btn btn-info">Back</a>
                            <button type="submit" name="Save" value="save" class="btn btn-primary float-right">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function subwindow_customer_selected(idx, id, name) {
        try {
            document.getElementById("customer_id").value = id;
            document.getElementById("customer_name").value = name;
            $.get("<?= base_url(); ?>/customer/get_customer/" + id, function(result) {
                var customers = JSON.parse(result);
                try {
                    document.getElementById("cp").value = customers[0].pic;
                    document.getElementById("phone").value = customers[0].phone;
                    document.getElementById("email").value = customers[0].email;
                } catch (e) {}
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