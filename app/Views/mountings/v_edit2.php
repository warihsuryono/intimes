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
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <ul class="list-group list-group-unbordered">
                                    <li class="list-group-item">
                                        <b>Vehicle Registration Plate</b> <a class="pull-right"><?= $vehicle->registration_plate; ?></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Vehicle Type</b> <a class="pull-right"><?= $vehicle_type; ?></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Vehicle Brand</b> <a class="pull-right"><?= $vehicle_brand; ?></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Tire Position</b> <a class="pull-right"><?= $tire_position->name; ?> (<?= $tire_position->code; ?>) </a>
                                    </li>
                                </ul>
                                <br>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Add Tire Code</label>
                                    <?= $_form->hidden("tire_id"); ?>
                                    <div class="input-group">
                                        <?= $_form->input("tire_qr_code", "", "required"); ?>
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-info btn-flat" onclick="qrcode_reader('tire_qr_code');"><i class="fa fa-barcode"></i></button>
                                        </span>
                                    </div>
                                </div>
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
                        </div>
                        <div class=" card-footer">
                            <a href="javascript:window.history.back();" class="btn btn-info">Back</a>
                            <button type="submit" name="Save" value="save" class="btn btn-primary float-right">Save</button>
                        </div>
                    </div>
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
        });
    }
</script>