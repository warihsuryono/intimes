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
                                    <label>Customer</label>
                                    <div class="input-group">
                                        <input type="hidden" id="calibration_verification_id" name="calibration_verification_id" value="<?= @$calibration_certificate->calibration_verification_id; ?>">
                                        <input type="hidden" id="customer_id" name="customer_id" value="<?= @$calibration_certificate->customer_id; ?>">
                                        <input type="text" class="form-control" id="customer_name" name="customer_name" value="<?= @$calibration_certificate->customer_name; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label>Address</label>
                                    <div class="input-group">
                                        <textarea class="form-control" id="address" name="address"><?= str_replace("<br>", "\n", @$calibration_certificate->address); ?></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label>Phone</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="phone" name="phone" value="<?= @$calibration_certificate->phone; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label>Fax</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="fax" name="fax" value="<?= @$calibration_certificate->fax; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label>Email</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="email" name="email" value="<?= @$calibration_certificate->fax; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label>Instrument Name</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="name" name="name" value="<?= @$calibration_certificate->name; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label>Identification Number/No Sampel</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="sample_no" value="<?= @$calibration_certificate->sample_no; ?>" name="sample_no" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Marek</label>
                                        <select class='form-control' id='brand_id' name='brand_id'>";
                                            <option></option>
                                            <?php foreach ($item_brands as $item_brand) : ?>
                                                <option value="<?= $item_brand->id; ?>" <?= (@$calibration_certificate->brand_id == $item_brand->id) ? "selected" : ""; ?>><?= $item_brand->name; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Tipe</label>
                                        <input type="text" class="form-control" id="instrument_type" value="<?= @$calibration_certificate->instrument_type; ?>" name="instrument_type">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Part Number</label>
                                        <input type="text" class="form-control" id="partno" value="<?= @$calibration_certificate->partno; ?>" name="partno">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Serial Number</label>
                                        <input type="text" class="form-control" id="serialnumber" value="<?= @$calibration_certificate->serialnumber; ?>" name="serialnumber">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Accepted At</label>
                                        <input type="date" class="form-control" id="accepted_at" name="accepted_at" value="<?= @$calibration_certificate->accepted_at; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Calibration At</label>
                                        <input type="date" class="form-control" id="process_start" name="process_start" value="<?= @$calibration_certificate->process_start; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Calibration Place</label>
                                        <input type="text" class="form-control" id="process_place" name="process_place" value="<?= @$calibration_certificate->process_place; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Calibration Method</label>
                                        <textarea class="form-control" id="method" name="method" rows="4"><?= str_replace("<br>", "\n", @$calibration_certificate->method); ?></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Relative Humidity</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="relative_humidity" name="relative_humidity" value="<?= @$calibration_certificate->relative_humidity; ?>">
                                            <label>&nbsp;&nbsp;&nbsp;&nbsp;+/-</label>
                                            <input type="number" step="0.1" class="form-control" id="relative_humidity_tolerance" name="relative_humidity_tolerance" value="<?= @$calibration_certificate->relative_humidity_tolerance; ?>">
                                            <label>%RH</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Temperature</label>
                                        <div class="input-group">
                                            <input type="number" step="0.1" class="form-control" id="temperature" name="temperature" value="<?= @$calibration_certificate->temperature; ?>">
                                            <label>&nbsp;&nbsp;&nbsp;&nbsp;+/-</label>
                                            <input type="number" step="0.1" class="form-control" id="temperature_tolerance" name="temperature_tolerance" value="<?= @$calibration_certificate->temperature_tolerance; ?>">
                                            <label>°C</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Traceability</label>
                                        <textarea class="form-control" id="traceability" name="traceability" rows="2"><?= str_replace("<br>", "\n", @$calibration_certificate->traceability); ?></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Issued At</label>
                                        <input type="date" class="form-control" id="issued_at" name="issued_at" value="<?= substr(@$calibration_certificate->issued_at, 0, 10); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body p-0">
                                <table class="table text-nowrap table-striped">
                                    <thead>
                                        <tr>
                                            <th>Jenis Gas</th>
                                            <th>Unit</th>
                                            <th>Range</th>
                                            <th>Resolution</th>
                                            <th>Tolerance (%)</th>
                                            <th>Standard</th>
                                            <th>Measured</th>
                                            <th>Correction</th>
                                            <th>U95% K=2</th>
                                            <th>Cylinder Number</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($calibration_certificate_details as $key => $calibration_certificate_detail) : ?>
                                            <tr>
                                                <td>
                                                    <input type="hidden" id="item_type_id[<?= $key; ?>]" name="item_type_id[<?= $key; ?>]" value="<?= @$calibration_certificate_detail->item_type_id; ?>">
                                                    <input type="hidden" id="unit_id[<?= $key; ?>]" name="unit_id[<?= $key; ?>]" value="<?= @$calibration_certificate_detail->unit_id; ?>">
                                                    <?= @$calibration_certificate_detail->item_type; ?>
                                                </td>
                                                <td><?= @$calibration_certificate_detail->unit; ?></td>
                                                <td><input type="text" style="width:100px;" id="scope[<?= $key; ?>]" name="scope[<?= $key; ?>]" value="<?= @$calibration_certificate_detail->scope; ?>"></td>
                                                <td><input type="number" step="0.01" style="width:100px;" id="resolution[<?= $key; ?>]" name="resolution[<?= $key; ?>]" value="<?= @$calibration_certificate_detail->resolution; ?>"></td>
                                                <td><input type="number" step="0.01" style="width:100px;" id="tolerance[<?= $key; ?>]" name="tolerance[<?= $key; ?>]" value="<?= @$calibration_certificate_detail->tolerance; ?>"></td>
                                                <td><input type="number" step="0.01" style="width:100px;" id="standard[<?= $key; ?>]" name="standard[<?= $key; ?>]" value="<?= @$calibration_certificate_detail->standard; ?>"></td>
                                                <td><input type="number" step="0.01" style="width:100px;" id="measured[<?= $key; ?>]" name="measured[<?= $key; ?>]" value="<?= @$calibration_certificate_detail->measured; ?>" onkeyup="correction(this);"></td>
                                                <td><input type="number" step="0.01" style="width:100px;" id="correction[<?= $key; ?>]" name="correction[<?= $key; ?>]" value="<?= @$calibration_certificate_detail->correction; ?>"></td>
                                                <td><input type="number" step="0.01" style="width:100px;" id="uncertainty[<?= $key; ?>]" name="uncertainty[<?= $key; ?>]" value="<?= @$calibration_certificate_detail->uncertainty; ?>"></td>
                                                <td><input type="text" id="cylinder_no[<?= $key; ?>]" name="cylinder_no[<?= $key; ?>]" value="<?= @$calibration_certificate_detail->cylinder_no; ?>"></td>

                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class=" card-footer">
                            <a href="<?= base_url(); ?>/calibration_certificates" class="btn btn-info">Back</a>
                            <?php if ($__mode != "add") : ?>
                                <a href="<?= base_url(); ?>/calibration_certificate/view/<?= $calibration_certificate->id; ?>" class="btn btn-info"><i class="fas fa-eye"></i> View</a>
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
    function correction(elm) {
        var idx = elm.id.replace("measured[", "").replace("]", "");
        var standard = document.getElementById("standard[" + idx + "]").value * 1;
        document.getElementById("correction[" + idx + "]").value = (standard - (elm.value * 1)).toFixed(2);
    }
</script>