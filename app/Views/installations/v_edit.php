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
                            <div class="row" id="tire_descriptions" style="display:none;">
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
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>SPK/PO Number</label>
                                        <?= $_form->input("spk_no", "", "required"); ?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>SPK/PO Date</label>
                                        <?= $_form->input("spk_at", "", "type='date' required"); ?>
                                    </div>
                                </div>
                                <?php if (@$installations_office_only) : ?>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>PO Price</label>
                                            <?= $_form->input("po_price", "", "type='number' required"); ?>
                                        </div>
                                    </div>
                                <?php endif ?>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Installed Date</label>
                                        <?= $_form->input("installed_at", "", "type='date' required"); ?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Vehicle No</label>
                                        <?= $_form->hidden("vehicle_id", "", "required"); ?>
                                        <div class="input-group">
                                            <?= $_form->input("vehicle_registration_plate", "", "required placeholder='Vehicle registration plate ...' readonly"); ?>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-flat" onclick="browse_vehicles('vehicle_id','vehicle_registration_plate');"><i class="fas fa-search"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Position</label>
                                        <?= $_form->select("tire_position_id", $tire_positions, ""); ?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Item</label>
                                        <?= $_form->select("tire_type_id", $tire_types, ""); ?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>KM Install</label>
                                        <?= $_form->input("km_install", "", "required"); ?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Original Tread Depth</label>
                                        <?= $_form->input("original_tread_depth", "", "required"); ?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Flap Installation</label>
                                        <?= $_form->select("is_flap", $yesnooption); ?>
                                    </div>
                                </div>
                                <?php if (@$installations_office_only) : ?>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Flap Price</label>
                                            <input name="flap_price" type="number" class="form-control">
                                        </div>
                                    </div>
                                <?php endif ?>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Tube Installation</label>
                                        <?= $_form->select("is_tube", $yesnooption); ?>
                                    </div>
                                </div>
                                <?php if (@$installations_office_only) : ?>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Tube Price</label>
                                            <input name="tube_price" type="number" class="form-control">
                                        </div>
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>
                        <div class=" card-footer">
                            <a href="<?= base_url(); ?>/tires" class="btn btn-info">Back</a>
                            <?php if ($__mode == "edit") : ?>
                                <a href="<?= base_url(); ?>/installation/takepictures/<?= $id; ?>" class="btn btn-info"><i class="fa fa-camera"></i>&nbsp;Take Pictures</a>
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
    function subwindow_vehicle_selected(idx, id, vehicle_registration_plate) {
        try {
            document.getElementById("vehicle_id").value = id;
            document.getElementById("vehicle_registration_plate").value = vehicle_registration_plate;
        } catch (e) {}
        $('#modal-form').modal('toggle');
    }

    function reload_subwindow_vehicles_area(keyword) {
        keyword = keyword || "";
        $.get("<?= base_url(); ?>/subwindow/vehicles?keyword=" + keyword, function(result) {
            $('#subwindow_list_area').html(result);
        });
    }

    function browse_vehicles() {
        var content = "<div class=\"row\">";
        content += "    <div class=\"col-12\">";
        content += "        <div class=\"form-group\">";
        content += "            <label>Search:</label>";
        content += "            <input name=\"keyword\" type=\"text\" class=\"form-control\" onkeyup=\"reload_subwindow_vehicles_area(this.value);\">";
        content += "        </div>";
        content += "    </div>";
        content += "</div>";
        content += "<div id=\"subwindow_list_area\"></div>";

        $('#modal_title').html('Vehicles');
        $('#modal_message').html(content);
        $('#modal_type').attr("class", 'modal-content');
        $('#modal_ok_link').attr("class", 'btn btn-danger');
        $('#modal_ok_link').html("Close");
        $('#modal_ok_link').attr("href", 'javascript:$(\'#modal-form\').modal(\'toggle\');');
        $('#modal-form').modal();
        reload_subwindow_vehicles_area("");
    }

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