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
                                        <input type="hidden" id="instrument_acceptance_id" name="instrument_acceptance_id" value="<?= @$request_review->instrument_acceptance_id; ?>">
                                        <input type="hidden" id="instrument_acceptance_detail_id" name="instrument_acceptance_detail_id" value="<?= @$request_review->instrument_acceptance_detail_id; ?>">
                                        <input type="text" class="form-control" id="sample_no" value="<?= @$request_review->sample_no; ?>" name="sample_no" readonly>
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-info btn-flat" onclick="browse_instrument_acceptances();"><i class="fas fa-search"></i></button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Permintaan Khusus Pelanggan</label>
                                        <textarea class="form-control" id="customer_request_1" name="customer_request_1"><?= @$request_review->customer_request_1; ?></textarea>
                                        <select class="form-control" name="customer_request_1_is">
                                            <option></option>
                                            <option value="1" <?= (@$request_review->customer_request_1_is == "1") ? "selected" : ""; ?>>Bisa</option>
                                            <option value="2" <?= (@$request_review->customer_request_1_is == "2") ? "selected" : ""; ?>>Tidak Bisa</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Permintaan Pelanggan Persyaratan Hukum</label>
                                        <textarea class="form-control" id="customer_request_2" name="customer_request_2"><?= @$request_review->customer_request_2; ?></textarea>
                                        <select class="form-control" name="customer_request_2_is">
                                            <option></option>
                                            <option value="1" <?= (@$request_review->customer_request_3_is == "1") ? "selected" : ""; ?>>Bisa</option>
                                            <option value="2" <?= (@$request_review->customer_request_3_is == "2") ? "selected" : ""; ?>>Tidak Bisa</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Permintaan Pelanggan Lainnya</label>
                                        <textarea class="form-control" id="customer_request_3" name="customer_request_3"><?= @$request_review->customer_request_3; ?></textarea>
                                        <select class="form-control" name="customer_request_3_is">
                                            <option></option>
                                            <option value="1" <?= (@$request_review->customer_request_3_is == "1") ? "selected" : ""; ?>>Bisa</option>
                                            <option value="2" <?= (@$request_review->customer_request_3_is == "2") ? "selected" : ""; ?>>Tidak Bisa</option>
                                        </select>
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
                                            <th>Parameter Gas</th>
                                            <th>Konsentrasi</th>
                                            <th>Identitas Metode</th>
                                            <th>Alat</th>
                                            <th>Personel</th>
                                            <th>Akomodasi</th>
                                            <th>Gas</th>
                                        </tr>
                                    </thead>
                                    <tbody id="details_body"></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Catatan</label>
                                        <input type="text" class="form-control" value="<?= @$request_review->notes; ?>" name="notes">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Kesimpulan</label>
                                        <div class="form-check">
                                            <input class="form-check-input" name="summary_id" type="radio" value="1" <?= (@$request_review->summary_id == "1") ? "checked" : ""; ?>>
                                            <label class="form-check-label">Instrumen Diterima</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" name="summary_id" type="radio" value="0" <?= (@$request_review->summary_id == "0") ? "checked" : ""; ?>>
                                            <label class="form-check-label">Instrumen Ditolak</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" name="summary_id" type="radio" value="2" <?= (@$request_review->summary_id == "2") ? "checked" : ""; ?>>
                                            <label class="form-check-label">Instrumen disubkontrakkan ke:</label>
                                            <input class="form-control" name="summary" value="<?= @$request_review->summary; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" card-footer">
                            <a href="<?= base_url(); ?>/request_reviews" class="btn btn-info">Back</a>
                            <?php if ($__mode != "add") : ?>
                                <a href="<?= base_url(); ?>/request_review/view/<?= $request_review->id; ?>" class="btn btn-info"><i class="fas fa-eye"></i> View</a>
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
            document.getElementById("instrument_acceptance_detail_id").value = instrument_acceptance_detail_id;
            document.getElementById("sample_no").value = sample_no;
            $.get("<?= base_url(); ?>/instrument_acceptance/get_instrument_acceptance?instrument_acceptance_id=" + instrument_acceptance_id, function(result) {
                var instrument_acceptance = JSON.parse(result);
                $('#customer_request_1').html("s/an " + instrument_acceptance.customer_name);
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