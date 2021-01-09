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
                                        <input type="hidden" id="instrument_process_id" name="instrument_process_id" value="<?= @$calibration_form->instrument_process_id; ?>">
                                        <input type="text" class="form-control" id="sample_no" value="<?= @$calibration_form->sample_no; ?>" name="sample_no" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Nama Alat</label>
                                        <select class='form-control' id='brand_id' name='brand_id'>";
                                            <option></option>
                                            <?php foreach ($item_brands as $item_brand) : ?>
                                                <option value="<?= $item_brand->id; ?>" <?= (@$calibration_form->brand_id == $item_brand->id) ? "selected" : ""; ?>><?= $item_brand->name; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Tipe</label>
                                        <input type="text" class="form-control" id="instrument_type" value="<?= @$calibration_form->instrument_type; ?>" name="instrument_type">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Part Number</label>
                                        <input type="text" class="form-control" id="partno" value="<?= @$calibration_form->partno; ?>" name="partno">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Serial Number</label>
                                        <input type="text" class="form-control" id="serialnumber" value="<?= @$calibration_form->serialnumber; ?>" name="serialnumber">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Calibration At</label>
                                        <input type="date" class="form-control" id="calibration_at" value="<?= @$calibration_form->calibration_at; ?>" name="calibration_at">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Suhu Ruangan (°C)</label>
                                        <input type="number" step="0.1" class="form-control" id="temperature" value="<?= @$calibration_form->temperature; ?>" name="temperature">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Kelembaban (%RH)</label>
                                        <input type="number" class="form-control" id="humidity" value="<?= @$calibration_form->humidity; ?>" name="humidity">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body p-0">
                                <table class="table text-nowrap table-striped">
                                    <tr>
                                        <td><b>Jenis Gas</b></td>
                                        <?php for ($i = 0; $i < 5; $i++) : ?>
                                            <td>
                                                <select name="item_type_id[<?= $i ?>]" id="item_type_id[<?= $i ?>]">
                                                    <option></option>
                                                    <?php foreach ($item_types as $item_type) : ?>
                                                        <option value="<?= $item_type->id; ?>" <?= (@$calibration_form_details[$i]->item_type_id == $item_type->id) ? "selected" : ""; ?>><?= $item_type->name; ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </td>
                                        <?php endfor ?>
                                    </tr>
                                    <tr>
                                        <td><b>Resolusi Alat</b></td>
                                        <?php for ($i = 0; $i < 5; $i++) : ?>
                                            <td>
                                                <input type="text" name="scope_id[<?= $i ?>]" id="scope_id[<?= $i ?>]" value="<?= @explode("||", substr(@$calibration_form->scope_ids, 1, -1))[$i]; ?>">
                                            </td>
                                        <?php endfor ?>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body p-0">
                                <table class="table text-nowrap table-striped">
                                    <thead>
                                        <tr>
                                            <th>Jenis Gas</th>
                                            <th>Satuan</th>
                                            <th>Konsentrasi</th>
                                            <?php for ($ii = 0; $ii < 10; $ii++) : ?>
                                                <th>Data <?= ($ii + 1); ?></th>
                                            <?php endfor ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($calibration_form_details as $key => $calibration_form_detail) : ?>
                                            <tr>
                                                <td>
                                                    <input type="hidden" id="item_type_id[<?= $key; ?>]" name="item_type_id[<?= $key; ?>]" value="<?= @$calibration_form_detail->item_type_id; ?>">
                                                    <input type="hidden" id="unit_id[<?= $key; ?>]" name="unit_id[<?= $key; ?>]" value="<?= @$calibration_form_detail->unit_id; ?>">
                                                    <input type="hidden" id="scope_id_detail[<?= $key; ?>]" name="scope_id_detail[<?= $key; ?>]" value="<?= @$calibration_form_detail->scope_id; ?>">
                                                    <?= $calibration_form_detail->item_type; ?>
                                                </td>
                                                <td><?= $calibration_form_detail->unit; ?></td>
                                                <td><?= $calibration_form_detail->item_scope->name; ?></td>
                                                <?php for ($ii = 0; $ii < 10; $ii++) : ?>
                                                    <td><input style="width:70px;" type="number" id="data[<?= $key; ?>][<?= $ii; ?>]" name="data[<?= $key; ?>][<?= $ii; ?>]" value="<?= @explode(";", @$calibration_form_detail->data_array)[$ii]; ?>"></td>
                                                <?php endfor ?>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class=" card-footer">
                            <a href="<?= base_url(); ?>/calibration_forms" class="btn btn-info">Back</a>
                            <?php if ($__mode != "add") : ?>
                                <a href="<?= base_url(); ?>/calibration_form/view/<?= $calibration_form->id; ?>" class="btn btn-info"><i class="fas fa-eye"></i> View</a>
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