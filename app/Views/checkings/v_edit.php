<!-- Main content -->
<style>
    .pull-right {
        float: right !important;
        color: #3c8dbc !important;
    }
</style>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <form role="form" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Tire Uniq Code</label>
                                        <input id="tire_id" name="tire_id" type="hidden" required>
                                        <div class="input-group">
                                            <input id="tire_qr_code" name="tire_qr_code" type="text" class="form-control" required>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-flat" onclick="qrcode_reader('tire_qr_code');"><i class="fa fa-barcode"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="tire_descriptions" Xstyle="display:none;">
                                <div class="col-sm-4">
                                    <ul class="list-group list-group-unbordered">
                                        <li class="list-group-item">
                                            <b>Size</b> <a class="pull-right" id="tire_size"></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Brand</b> <a class="pull-right" id="tire_brand"></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Type</b> <a class="pull-right" id="tire_type"></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Pattern</b> <a class="pull-right" id="tire_pattern"></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Original Tread Depth</b> <a class="pull-right" id="tread_depth"></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>PSI</b> <a class="pull-right" id="psi"></a>
                                        </li>
                                    </ul>
                                    <br>
                                </div>
                                <div class="col-sm-4">
                                    <ul class="list-group list-group-unbordered">
                                        <li class="list-group-item">
                                            <b>Position Before</b> <a class="pull-right" id="old_position"></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Position Changed ?</b>
                                            <div class="pull-right"><?= $_form->input("tire_position_changed", "", "type='checkbox'"); ?> Yes</div>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Remark</b>
                                            <?= $_form->textarea("tire_position_remark"); ?>
                                        </li>
                                        <li class="list-group-item">
                                            <b>KM Install</b> <a class="pull-right" id="km_install"></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>KM Last Checked</b> <a class="pull-right" id="check_km_last"></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Last Remain Tread Depth</b> <a class="pull-right" id="remain_tread_depth_last"></a>
                                        </li>
                                    </ul>
                                    <br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Current Position</label>
                                        <?= $_form->select("tire_position_id", $tire_positions, ""); ?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>KM Check</label>
                                        <?= $_form->input("check_km", "", "required"); ?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Check Date</label>
                                        <?= $_form->input("check_at", "", "type='date' required"); ?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Remain Tread Depth</label>
                                        <?= $_form->input("remain_tread_depth", "", "type='number' required"); ?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>PSI</label>
                                        <?= $_form->input("psi", "", "type='number'"); ?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Notes</label>
                                        <?= $_form->textarea("notes"); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" card-footer">
                            <a href="<?= base_url(); ?>/checkings" class="btn btn-info">Back</a>
                            <?php if ($__mode == "edit") : ?>
                                <a href="<?= base_url(); ?>/checking/takepictures/<?= $id; ?>" class="btn btn-info"><i class="fa fa-camera"></i>&nbsp;Take Pictures</a>
                            <?php endif ?>
                            <button type="submit" name="Save" value="save" class="btn btn-primary float-right">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function on_qr_success(qrcode) {
        $.get("<?= base_url(); ?>/tire/get_item_by_qrcode/" + qrcode, function(result) {
            var tire = JSON.parse(result.replace("[", "").replace("]", ""));
            try {
                $("#tire_id").val(tire.id);
            } catch (e) {}
            try {
                $("#tire_size").html(tire.size.name);
            } catch (e) {}
            try {
                $("#tire_brand").html(tire.brand.name);
            } catch (e) {}
            try {
                $("#tire_type").html(tire._type.name);
            } catch (e) {}
            try {
                $("#tire_pattern").html(tire.pattern.name);
            } catch (e) {}
            try {
                $("#tread_depth").html(tire.tread_depth);
            } catch (e) {}
            try {
                $("#psi").html(tire.psi);
            } catch (e) {}
            try {
                $("[name='tread_depth']").val(tire.tread_depth);
            } catch (e) {}
            $("#tire_descriptions").fadeIn();
        });
    }
</script>