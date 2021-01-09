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
                                    <label>Instrument (No Sampel)</label>
                                    <div class="input-group">
                                        <input type="hidden" id="instrument_acceptance_id" name="instrument_acceptance_id" value="<?= @$instrument_release->instrument_acceptance_id; ?>">
                                        <input type="text" class="form-control" id="sample_no" name="sample_no" value="<?= @$instrument_release->sample_no; ?>" readonly>
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-info btn-flat" onclick="browse_instrument_acceptances();"><i class="fas fa-search"></i></button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Customer</label>
                                        <input type="hidden" id="customer_id" name="customer_id" value="<?= @$instrument_release->customer_id; ?>">
                                        <input type="text" class="form-control" id="customer_name" name="customer_name" value="<?= @$instrument_release->customer_name; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Customer Address</label>
                                        <textarea type="text" class="form-control" id="address" name="address"><?= @$instrument_release->address; ?></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Diserahkan pada</label>
                                        <input type="date" class="form-control" id="release_at" name="release_at" value="<?= substr(@$instrument_release->release_at, 0, 10); ?>">
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
                                            <th>Part#</th>
                                            <th>S/N</th>
                                            <th>Description</th>
                                            <th>Qty</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody id="details_body"></tbody>
                                </table>
                            </div>
                        </div>
                        <div class=" card-footer">
                            <a href="<?= base_url(); ?>/instrument_releases" class="btn btn-info">Back</a>
                            <?php if ($__mode != "add") : ?>
                                <a href="<?= base_url(); ?>/instrument_release/view/<?= $instrument_release->id; ?>" class="btn btn-info"><i class="fas fa-eye"></i> View</a>
                            <?php endif ?>
                            <input type="submit" name="Save" value="save" class="btn btn-primary float-right">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function subwindow_instrument_acceptance_selected(instrument_acceptance_id, instrument_acceptance_detail_id, sample_no) {
        try {
            document.getElementById("instrument_acceptance_id").value = instrument_acceptance_id;
            document.getElementById("sample_no").value = sample_no;
            $('#release_at').val("<?= date("Y-m-d"); ?>");
            $.get("<?= base_url(); ?>/instrument_acceptance/get_instrument_acceptance?instrument_acceptance_id=" + instrument_acceptance_id, function(result) {
                var instrument_acceptance = JSON.parse(result);
                $('#customer_id').val(instrument_acceptance.customer_id);
                $('#customer_name').val(instrument_acceptance.customer_name);
                $.get("<?= base_url(); ?>/Customer/get_customer/" + instrument_acceptance.customer_id, function(result2) {
                    var customer = JSON.parse(result2);
                    $('#address').html(customer[0].address);
                });
            });
        } catch (e) {}
        $('#modal-form').modal('toggle');
    }

    function reload_subwindow_instrument_acceptances_area(keyword) {
        keyword = keyword || "";
        $.get("<?= base_url(); ?>/subwindow/instrument_acceptances?keyword=" + keyword, function(result) {
            $('#subwindow_list_area').html(result);
        });
    }

    function browse_instrument_acceptances() {
        var content = "<div class=\"row\">";
        content += "    <div class=\"col-12\">";
        content += "        <div class=\"form-group\">";
        content += "            <label>Search:</label>";
        content += "            <input name=\"keyword\" type=\"text\" class=\"form-control\" onkeyup=\"reload_subwindow_instrument_acceptances_area(this.value);\">";
        content += "        </div>";
        content += "    </div>";
        content += "</div>";
        content += "<div id=\"subwindow_list_area\"></div>";

        $('#modal_title').html('Instrument Acceptance');
        $('#modal_message').html(content);
        $('#modal_type').attr("class", 'modal-content');
        $('#modal_ok_link').attr("class", 'btn btn-danger');
        $('#modal_ok_link').html("Close");
        $('#modal_ok_link').attr("href", 'javascript:$(\'#modal-form\').modal(\'toggle\');');
        $('#modal-form').modal();
        reload_subwindow_instrument_acceptances_area("");
    }
</script>