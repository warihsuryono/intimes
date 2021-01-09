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
                                    <label for="customer_id">Customer</label>
                                    <div class="input-group">
                                        <input type="hidden" id="customer_id" name="customer_id" value="<?= @$instrument_acceptance->customer_id; ?>">
                                        <input type="text" class="form-control" id="customer_name" value="<?= @$instrument_acceptance->customer_name; ?>" name="customer_name" placeholder="Customer Name" readonly>
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-info btn-flat" onclick="browse_customers('customer_id','customer_name');"><i class="fas fa-search"></i></button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Diserahkan oleh</label>
                                        <input class="form-control" id="submitted_by" name="submitted_by" placeholder="Diserahkan oleh" value="<?= @$instrument_acceptance->submitted_by; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Tenggat Waktu</label>
                                        <input class="form-control" name="deadlines" type="date" value="<?= @$instrument_acceptance->deadlines; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="request_at">Tindakan</label>
                                        <div class="form-check">
                                            <input class="form-check-input" name="action_id" type="radio" value="1" <?= (@$instrument_acceptance->action_id == "1") ? "checked" : ""; ?>>
                                            <label class="form-check-label">Kalibrasi</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" name="action_id" type="radio" value="2" <?= (@$instrument_acceptance->action_id == "2") ? "checked" : ""; ?>>
                                            <label class="form-check-label">IPC</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" name="action_id" type="radio" value="3" <?= (@$instrument_acceptance->action_id == "3") ? "checked" : ""; ?>>
                                            <label class="form-check-label">Maintenance & Repair</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" name="action_id" type="radio" value="0" <?= (@$instrument_acceptance->action_id == "0") ? "checked" : ""; ?>>
                                            <label class="form-check-label">Lain-lain:</label>
                                            <input class="form-control" name="action_etc" value="<?= @$instrument_acceptance->action_etc; ?>">
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
                                            <th>No Sampel</th>
                                            <th>Merk</th>
                                            <th>Tipe</th>
                                            <th>Part #</th>
                                            <th>S/N</th>
                                            <th>Kelengkapan Alat</th>
                                            <th>Kondisi Alat</th>
                                        </tr>
                                    </thead>
                                    <tbody id="details_body"></tbody>
                                </table>
                            </div>
                            <div class=" card-footer">
                                <a href="<?= base_url(); ?>/instrument_acceptances" class="btn btn-info">Back</a>
                                <?php if ($__mode != "add") : ?>
                                    <a href="<?= base_url(); ?>/instrument_acceptance/view/<?= $instrument_acceptance->id; ?>" class="btn btn-info"><i class="fas fa-eye"></i> View</a>
                                <?php endif ?>
                                <input type="submit" name="Save" value="save" class="btn btn-primary float-right">
                            </div>
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
</script>