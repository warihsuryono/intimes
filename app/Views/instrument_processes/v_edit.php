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
                                        <input type="hidden" id="instrument_acceptance_id" name="instrument_acceptance_id" value="<?= @$instrument_process->instrument_acceptance_id; ?>">
                                        <input type="hidden" id="instrument_acceptance_detail_id" name="instrument_acceptance_detail_id" value="<?= @$instrument_process->instrument_acceptance_detail_id; ?>">
                                        <input type="hidden" id="request_review_id" name="request_review_id" value="<?= @$instrument_process->request_review_id; ?>">
                                        <input type="text" class="form-control" id="sample_no" value="<?= @$instrument_process->sample_no; ?>" name="sample_no" readonly>
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-info btn-flat" onclick="browse_request_reviews();"><i class="fas fa-search"></i></button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Nama Alat</label>
                                        <select class='form-control' id='brand_id' name='brand_id'>";
                                            <option></option>
                                            <?php foreach ($item_brands as $item_brand) : ?>
                                                <option value="<?= $item_brand->id; ?>" <?= (@$instrument_process->brand_id == $item_brand->id) ? "selected" : ""; ?>><?= $item_brand->name; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Tipe</label>
                                        <input type="text" class="form-control" id="instrument_type" value="<?= @$instrument_process->instrument_type; ?>" name="instrument_type">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Part Number</label>
                                        <input type="text" class="form-control" id="partno" value="<?= @$instrument_process->partno; ?>" name="partno">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Serial Number</label>
                                        <input type="text" class="form-control" id="serialnumber" value="<?= @$instrument_process->serialnumber; ?>" name="serialnumber">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Resolusi</label>
                                        <input type="text" class="form-control" id="resolution" value="<?= @$instrument_process->resolution; ?>" name="resolution">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Akurasi (+/- (%))</label>
                                        <input type="number" class="form-control" id="accuration" value="<?= @$instrument_process->accuration; ?>" name="accuration">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Tanggal Awal Pekerjaan</label>
                                        <input type="date" class="form-control" id="process_start" value="<?= @$instrument_process->process_start; ?>" name="process_start">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Tanggal Selesai Pekerjaan</label>
                                        <input type="date" class="form-control" id="process_end" value="<?= @$instrument_process->process_end; ?>" name="process_end">
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
                                            <th>Pengecekan yang dilakukan</th>
                                            <th>Kondisi hasil pengecekan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="details_body"></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h4><b>Produk/Jasa</b></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>BCS</label>
                                        <select class="form-control" name="is_bcs" id="is_bcs">
                                            <option value='0' <?= (@$instrument_process->is_bcs == 0) ? "selected" : ""; ?>>Tidak dikerjakan</option>
                                            <option value='1' <?= (@$instrument_process->is_bcs == 1) ? "selected" : ""; ?>>Dikerjakan</option>
                                        </select>
                                        <input type="text" class="form-control" value="<?= @$instrument_process->notes_bcs; ?>" id="notes_bcs" name="notes_bcs" placeholder="Keterangan">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>IPC</label>
                                        <select class="form-control" name="is_ipc" id="is_ipc">
                                            <option value='0' <?= (@$instrument_process->is_ipc == 0) ? "selected" : ""; ?>>Tidak dikerjakan</option>
                                            <option value='1' <?= (@$instrument_process->is_ipc == 1) ? "selected" : ""; ?>>Dikerjakan</option>
                                        </select>
                                        <input type="text" class="form-control" value="<?= @$instrument_process->notes_ipc; ?>" id="notes_ipc" name="notes_ipc" placeholder="Keterangan">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Kalibrasi</label>
                                        <select class="form-control" name="is_calibration" id="is_calibration">
                                            <option value='0' <?= (@$instrument_process->is_calibration == 0) ? "selected" : ""; ?>>Tidak dikerjakan</option>
                                            <option value='1' <?= (@$instrument_process->is_calibration == 1) ? "selected" : ""; ?>>Dikerjakan</option>
                                        </select>
                                        <input type="text" class="form-control" value="<?= @$instrument_process->notes_calibration; ?>" id="notes_calibration" name="notes_calibration" placeholder="Keterangan">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Maintenance & Repair</label>
                                        <select class="form-control" name="is_maintenance" id="is_maintenance">
                                            <option value='0' <?= (@$instrument_process->is_maintenance == 0) ? "selected" : ""; ?>>Tidak dikerjakan</option>
                                            <option value='1' <?= (@$instrument_process->is_maintenance == 1) ? "selected" : ""; ?>>Dikerjakan</option>
                                        </select>
                                        <input type="text" class="form-control" value="<?= @$instrument_process->notes_maintenance; ?>" id="notes_maintenance" name="notes_maintenance" placeholder="Keterangan">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Service Kontrak</label>
                                        <select class="form-control" name="is_contract_service" id="is_contract_service">
                                            <option value='0' <?= (@$instrument_process->is_contract_service == 0) ? "selected" : ""; ?>>Tidak dikerjakan</option>
                                            <option value='1' <?= (@$instrument_process->is_contract_service == 1) ? "selected" : ""; ?>>Dikerjakan</option>
                                        </select>
                                        <input type="text" class="form-control" value="<?= @$instrument_process->notes_contract_service; ?>" id="notes_contract_service" name="notes_contract_service" placeholder="Keterangan">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" card-footer">
                            <a href="<?= base_url(); ?>/instrument_processes" class="btn btn-info">Back</a>
                            <?php if ($__mode != "add") : ?>
                                <a href="<?= base_url(); ?>/instrument_process/view/<?= $instrument_process->id; ?>" class="btn btn-info"><i class="fas fa-eye"></i> View</a>
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
    function subwindow_request_review_selected(request_review_id, instrument_acceptance_id, instrument_acceptance_detail_id, sample_no) {
        try {
            document.getElementById("instrument_acceptance_id").value = instrument_acceptance_id;
            document.getElementById("instrument_acceptance_detail_id").value = instrument_acceptance_detail_id;
            document.getElementById("request_review_id").value = request_review_id;
            document.getElementById("sample_no").value = sample_no;
            $.get("<?= base_url(); ?>/instrument_acceptance/get_instrument_acceptance_detail?instrument_acceptance_detail_id=" + instrument_acceptance_detail_id, function(result) {
                var instrument_acceptance_detail = JSON.parse(result);
                $('#brand_id').val(instrument_acceptance_detail.brand_id);
                $('#instrument_type').val(instrument_acceptance_detail.instrument_type);
                $('#partno').val(instrument_acceptance_detail.partno);
                $('#serialnumber').val(instrument_acceptance_detail.serialnumber);
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

        $('#modal_title').html('Kaji Ulang Kontrak');
        $('#modal_message').html(content);
        $('#modal_type').attr("class", 'modal-content');
        $('#modal_ok_link').attr("class", 'btn btn-danger');
        $('#modal_ok_link').html("Close");
        $('#modal_ok_link').attr("href", 'javascript:$(\'#modal-form\').modal(\'toggle\');');
        $('#modal-form').modal();
        reload_subwindow_request_reviews_area("");
    }
</script>