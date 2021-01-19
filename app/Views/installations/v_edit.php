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
                    <form role="form" method="POST">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Tire</label>
                                        <input id="tire_id" name="tire_id" type="hidden">
                                        <div class="input-group">
                                            <input id="tire_qr_code" name="tire_qr_code" type="text" class="form-control">
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
                                        <label>SPK No</label>
                                        <input name="spk_no" type="text" class="form-control" placeholder="SPK No">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>SPK At</label>
                                        <input name="spk_at" type="date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Installed At</label>
                                        <input name="installed_at" type="date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Vehicle</label>
                                        <input id="vehicle_id" name="vehicle_id" type="hidden">
                                        <div class="input-group">
                                            <input id="vehicle_registration_plate" name="vehicle_registration_plate" type="text" class="form-control" placeholder="vehicle_registration_plate ...">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-flat" onclick="browse_vehicles('vehicle_id','vehicle_registration_plate');"><i class="fas fa-search"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Position</label>
                                        <select name="tire_position_id" class="form-control">
                                            <option value="">-- Select Tire Position --</option>
                                            <?php foreach ($tire_positions as $tire_position) : ?>
                                                <option value="<?= $tire_position->id; ?>"><?= $tire_position->name; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Vulkanisir</label>
                                        <select name="is_retread" class="form-control">
                                            <option value=""></option>
                                            <option value="1">Yes</option>
                                            <option value="2">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Price</label>
                                        <input name="price" type="number" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Flap Installation</label>
                                        <input name="flap_installation" type="text" class="form-control" placeholder="Flap Installation">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Flap Price</label>
                                        <input name="flap_price" type="number" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Disassembled Tire</label>
                                        <input name="disassembled_tire" type="text" class="form-control" placeholder="Disassembled Tire">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>KM</label>
                                        <input name="km" type="text" class="form-control" placeholder="KM">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Tread Depth</label>
                                        <input name="tread_depth" type="text" class="form-control" placeholder="Tread Depth">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Photo</label>
                                        <input name="tread_depth" type="file" class="form-control" capture="camera">
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
</script>