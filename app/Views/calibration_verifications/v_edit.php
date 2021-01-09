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
                                        <input type="hidden" id="calibration_form_id" name="calibration_form_id" value="<?= @$calibration_verification->calibration_form_id; ?>">
                                        <input type="text" class="form-control" id="sample_no" value="<?= @$calibration_verification->sample_no; ?>" name="sample_no" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Nama Alat</label>
                                        <select class='form-control' id='brand_id' name='brand_id'>";
                                            <option></option>
                                            <?php foreach ($item_brands as $item_brand) : ?>
                                                <option value="<?= $item_brand->id; ?>" <?= (@$calibration_verification->brand_id == $item_brand->id) ? "selected" : ""; ?>><?= $item_brand->name; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Tipe</label>
                                        <input type="text" class="form-control" id="instrument_type" value="<?= @$calibration_verification->instrument_type; ?>" name="instrument_type">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Serial Number</label>
                                        <input type="text" class="form-control" id="serialnumber" value="<?= @$calibration_verification->serialnumber; ?>" name="serialnumber">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Notes</label>
                                        <textarea class="form-control" rows="15" id="notes" name="notes"><?= @$calibration_verification->notes; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class=" card-footer">
                            <a href="<?= base_url(); ?>/calibration_verifications" class="btn btn-info">Back</a>
                            <?php if ($__mode != "add") : ?>
                                <a href="<?= base_url(); ?>/calibration_verification/view/<?= $calibration_verification->id; ?>" class="btn btn-info"><i class="fas fa-eye"></i> View</a>
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
    function subwindow_request_review_selected(request_review_id, request_review_detail_id, sample_no) {
        try {
            document.getElementById("request_review_id").value = request_review_id;
            document.getElementById("request_review_detail_id").value = request_review_detail_id;
            document.getElementById("sample_no").value = sample_no;
            $.get("<?= base_url(); ?>/request_review/get_request_review_detail?request_review_detail_id=" + request_review_detail_id, function(result) {
                var request_review_detail = JSON.parse(result);
                $('#brand_id').val(request_review_detail.brand_id);
                $('#instrument_type').val(request_review_detail.instrument_type);
                $('#partno').val(request_review_detail.partno);
                $('#serialnumber').val(request_review_detail.serialnumber);
                $('#process_start').val("<?= date("Y-m-d"); ?>");
                $('#process_end').val("<?= date("Y-m-d"); ?>");
            });
        } catch (e) {}
        $('#modal-form').modal('toggle');
    }

    function reload_subwindow_request_reviews_area(keyword) {
        keyword = keyword || "";
        $.get("<?= base_url(); ?>/subwindow/request_reviews?keyword=" + keyword, function(result) {
            $('#subwindow_list_area').html(result);
        });
    }

    function browse_request_reviews() {
        var content = "<div class=\"row\">";
        content += "    <div class=\"col-12\">";
        content += "        <div class=\"form-group\">";
        content += "            <label>Search:</label>";
        content += "            <input name=\"keyword\" type=\"text\" class=\"form-control\" onkeyup=\"reload_subwindow_request_reviews_area(this.value);\">";
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
        reload_subwindow_request_reviews_area("");
    }
</script>