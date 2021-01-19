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
                                    <div class="form-group">
                                        <label>QR Code</label>
                                        <div class="input-group">
                                            <input id="qrcode" name="qrcode" type="text" class="form-control" placeholder="QR Code ...">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-flat" onclick="qrcode_reader('qrcode');"><i class="fa fa-barcode"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Serial No</label>
                                        <input name="serialno" type="text" class="form-control" placeholder="Serial No ...">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Tire Size</label>
                                        <select name="tire_size_id" class="form-control">
                                            <option value="">-- Select Tire Size --</option>
                                            <?php foreach ($tire_sizes as $tire_size) : ?>
                                                <option value="<?= $tire_size->id; ?>"><?= $tire_size->name; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Tire Brand</label>
                                        <select name="tire_brand_id" class="form-control">
                                            <option value="">-- Select Tire Brand --</option>
                                            <?php foreach ($tire_brands as $tire_brand) : ?>
                                                <option value="<?= $tire_brand->id; ?>"><?= $tire_brand->name; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Tire Type</label>
                                        <select name="tire_type_id" class="form-control">
                                            <option value="">-- Select Tire Type --</option>
                                            <?php foreach ($tire_types as $tire_type) : ?>
                                                <option value="<?= $tire_type->id; ?>"><?= $tire_type->name; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Tire Pattern</label>
                                        <select name="tire_pattern_id" class="form-control">
                                            <option value="">-- Select Tire Pattern --</option>
                                            <?php foreach ($tire_patterns as $tire_pattern) : ?>
                                                <option value="<?= $tire_pattern->id; ?>"><?= $tire_pattern->name; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Tread Depth</label>
                                        <input type="number" step="0.1" name="tread_depth" class="form-control" placeholder="Tread Depth">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>PSI</label>
                                        <input type="number" step="0.1" name="psi" class="form-control" placeholder="PSI">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Remark</label>
                                        <textarea name="remark" class="form-control" placeholder="Remark"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" card-footer">
                            <a href="<?= base_url(); ?>/tires" class="btn btn-info">Back</a>
                            <button type="submit" name="Save" value="save" class="btn btn-primary float-right">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>