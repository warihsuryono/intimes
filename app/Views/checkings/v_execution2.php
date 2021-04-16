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
                                            <input id="tire_qr_code" name="tire_qr_code" type="text" class="form-control" onblur="on_qr_success(this.value)" required <?= ($__mode == "add") ? "" : "readonly"; ?>>
                                            <?php if ($__mode == "add") : ?>
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-info btn-flat" onclick="qrcode_reader('tire_qr_code');"><i class="fa fa-barcode"></i></button>
                                                </span>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="tire_descriptions" style="display:none;">
                                <div class="col-sm-4">
                                    <div class="form-group" id="tires_map"></div>
                                </div>
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
                                    </ul>
                                    <br>
                                </div>
                                <div class="col-sm-4">
                                    <ul class="list-group list-group-unbordered">
                                        <li class="list-group-item">
                                            <b>Position Before</b> <a class="pull-right" id="old_position"></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>KM Mounting</b> <a class="pull-right" id="mount_km"></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Original Tread Depth</b> <a class="pull-right" id="tread_depth"></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>PSI</b> <a class="pull-right" id="psi"></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Last Remain Tread Depth</b> <a class="pull-right" id="remain_tread_depth_last"></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Position Changed ?</b>
                                            <div class="pull-right"><?= $_form->input("tire_position_changed", "1", "type='checkbox' onchange='changing_tire_position(this)'"); ?> Yes</div>
                                        </li>
                                        <script>
                                            function changing_tire_position(elm) {
                                                if (elm.checked) {
                                                    $("#tire_position_remark_area").fadeIn();
                                                    $("#tire_position_decision_area").fadeIn();
                                                } else {
                                                    $("#tire_position_remark_area").fadeOut();
                                                    $("#tire_position_decision_area").fadeOut();
                                                    $("#remark").val("");
                                                    $("#decision").val("");
                                                }
                                            }
                                        </script>
                                        <li class="list-group-item" id="tire_position_remark_area" style="display:none;">
                                            <b>Remark</b>
                                            <?= $_form->textarea("remark", ""); ?>
                                        </li>
                                        <li class="list-group-item" id="tire_position_decision_area" style="display:none;">
                                            <b>Decision</b>
                                            <?= $_form->select("decision", $decisions); ?>
                                        </li>
                                        <li class="list-group-item">
                                            <b>KM Last Checked</b> <a class="pull-right" id="check_km_last"></a>
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
                                        <?= $_form->input("km", "", "required"); ?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Check Date</label>
                                        <?= $_form->input("checking_at", date("Y-m-d"), "type='date' required"); ?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Remain Tread Depth 1,2,3,4</label>
                                        <div class="input-group">
                                            <?= $_form->input("rtd1", "", "type='number' required"); ?>
                                            <?= $_form->input("rtd2", "", "type='number' required"); ?>
                                            <?= $_form->input("rtd3", "", "type='number' required"); ?>
                                            <?= $_form->input("rtd4", "", "type='number' required"); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>PSI Before</label>
                                        <?= $_form->input("psi_before", "", "type='number'"); ?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>PSI After</label>
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
            $.get("<?= base_url(); ?>/checking/get_last_checking/" + tire.id, function(result) {
                var last_checking = JSON.parse(result.replace("[", "").replace("]", ""));
                try {
                    $("#old_position").html(last_checking.tire_position.name);
                    $("#mount_km").html(last_checking.mount_km);
                    $("#check_km_last").html(last_checking.check_km);
                    $("#remain_tread_depth_last").html(last_checking.remain_tread_depth);
                } catch (e) {}
            });
            $.get("<?= base_url(); ?>/checking/get_tires_map/" + qrcode, function(result) {
                $("#tires_map").html(result);
                if ($("#tiresrow").val() == 1) $("#tires_map").height(200);
                if ($("#tiresrow").val() == 2) $("#tires_map").height(300);
                if ($("#tiresrow").val() == 3) $("#tires_map").height(400);
                if ($("#tiresrow").val() == 4) $("#tires_map").height(500);
                if ($("#tiresrow").val() == 5) $("#tires_map").height(600);
                if ($("#tiresrow").val() == 6) $("#tires_map").height(700);
            });
        });
    }

    function tire_position_clicked(tire_position_id) {
        <?php if (@$mounting->id > 0) : ?>
            $.get("<?= base_url(); ?>/checking/get_qrcode_by_tire_position_id/<?= $mounting->id; ?>/" + tire_position_id, function(result) {
                if (result) {
                    on_qr_success(result);
                    $("#tire_qr_code").val(result);
                } else {
                    try {
                        $("#tire_id").val("");
                    } catch (e) {}
                    try {
                        $("#tire_size").html("");
                    } catch (e) {}
                    try {
                        $("#tire_brand").html("");
                    } catch (e) {}
                    try {
                        $("#tire_type").html("");
                    } catch (e) {}
                    try {
                        $("#tire_pattern").html("");
                    } catch (e) {}
                    try {
                        $("#tread_depth").html("");
                    } catch (e) {}
                    try {
                        $("#psi").html("");
                    } catch (e) {}
                    try {
                        $("[name='tread_depth']").val("");
                    } catch (e) {}
                }
            });
        <?php endif ?>
        $("#tire_position_id").val(tire_position_id);
        for (var i = 1; i < 30; i++) {
            try {
                $("#tires_map_" + i).addClass("btn-info");
                $("#tires_map_" + i).removeClass("btn-warning");
            } catch (ex) {}
        }
        $("#tires_map_" + tire_position_id).addClass("btn-warning");
        $("#tires_map_" + tire_position_id).removeClass("btn-info");
    }

    function pageloaded() {
        $.get("<?= base_url(); ?>/mounting/get_tires_map/<?= @$vehicle_type_id; ?>", function(result) {
            $("#tire_descriptions").fadeIn();
            $("#tires_map").html(result);
            if ($("#tiresrow").val() == 1) $("#tires_map").height(200);
            if ($("#tiresrow").val() == 2) $("#tires_map").height(300);
            if ($("#tiresrow").val() == 3) $("#tires_map").height(400);
            if ($("#tiresrow").val() == 4) $("#tires_map").height(500);
            if ($("#tiresrow").val() == 5) $("#tires_map").height(600);
            if ($("#tiresrow").val() == 6) $("#tires_map").height(700);
            // $("#tires_map").children().removeClass("btn-info");
            // $("#tires_map").children().addClass("btn-secondary");
        });
    }
</script>