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
                    <form role="form" id="mainform" method="POST">
                        <?= $_form->hidden("saving_page_2"); ?>
                        <?= $_form->hidden("tire_position_id"); ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <ul class="list-group list-group-unbordered">
                                        <li class="list-group-item">
                                            <b>SPK/PO Number</b> <a class="pull-right"><?= $mounting->spk_no; ?></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>SPK/PO Date</b> <a class="pull-right"><?= date("d F Y", strtotime($mounting->spk_at)); ?></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Customer Name</b> <a class="pull-right"><?= $mounting->customer_name; ?></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Vehicle Registration Plate</b> <a class="pull-right"><?= $vehicle->registration_plate; ?></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Vehicle Type</b> <a class="pull-right"><?= $vehicle_type; ?></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Vehicle Brand</b> <a class="pull-right"><?= $vehicle_brand; ?></a>
                                        </li>
                                    </ul>
                                    <br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group" id="tires_map"><?= $tires_map; ?></div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Add Tire Code</label>
                                        <?= $_form->hidden("tire_id"); ?>
                                        <div class="input-group">
                                            <?= $_form->input("tire_qr_code", "", "required onblur=\"on_qr_success(this.value)\""); ?>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-flat" onclick="qrcode_reader('tire_qr_code');"><i class="fa fa-barcode"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                    <ul class="list-group list-group-unbordered">
                                        <li class="list-group-item">
                                            <b>Tire Position</b> <a class="pull-right" id="tire_position"></a>
                                        </li>
                                        <li class="list-group-item" style="display:none;" id="li_tire_size">
                                            <b>Size</b> <a class="pull-right" id="tire_size"></a>
                                        </li>
                                        <li class="list-group-item" style="display:none;" id="li_tire_brand">
                                            <b>Brand</b> <a class="pull-right" id="tire_brand"></a>
                                        </li>
                                        <li class="list-group-item" style="display:none;" id="li_tire_type">
                                            <b>Type</b> <a class="pull-right" id="tire_type"></a>
                                        </li>
                                        <li class="list-group-item" style="display:none;" id="li_tire_pattern">
                                            <b>Pattern</b> <a class="pull-right" id="tire_pattern"></a>
                                        </li>
                                        <li class="list-group-item" style="display:none;" id="li_tread_depth">
                                            <b>Original Tread Depth</b> <a class="pull-right" id="tread_depth"></a>
                                        </li>
                                        <li class="list-group-item" style="display:none;" id="li_psi">
                                            <b>PSI</b> <a class="pull-right" id="psi"></a>
                                        </li>
                                    </ul>
                                    <br>
                                </div>
                                <div class="col-sm-4">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Size</label><?= $_form->select("tire_size_id", $tire_sizes); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Brands</label><?= $_form->select("tire_brand_id", $tire_brands); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Type</label><?= $_form->select("tire_type_id", $tire_types); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Pattern</label><?= $_form->select("tire_pattern_id", $tire_patterns); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>KM</label><?= $_form->input("km", @$mounting_details[0]->km); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>OTD</label><?= $_form->input("otd"); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Remark</label><?= $_form->input("remark"); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <button name="save" class="btn btn-primary">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0" style="height: 700px;">
                            <table class="table table-head-fixed text-nowrap table-striped">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Code</th>
                                        <th>Type</th>
                                        <th>Position</th>
                                        <th>KM</th>
                                        <th>OTD</th>
                                        <th>Remark</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($mounting_details as $key => $mounting_detail) : ?>
                                        <tr>
                                            <td>
                                                <a class="btn btn-info btn-sm" href="<?= base_url(); ?>/mounting/photos/<?= $mounting_detail->id; ?>">
                                                    <i class="fa fa-camera"></i>
                                                </a>
                                                <a class="btn btn-danger btn-sm" href="#" onclick="delete_confirmation(<?= $mounting_detail->id; ?>);">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                            <td><?= $mounting_detail->code; ?></td>
                                            <td><?= $mounting_detail->tire_type->name; ?></td>
                                            <td><?= $mounting_detail->tire_position->name; ?> (<?= $mounting_detail->tire_position->code; ?>)</td>
                                            <td><?= $mounting_detail->km; ?></td>
                                            <td><?= $mounting_detail->otd; ?></td>
                                            <td><?= $mounting_detail->remark; ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                        <div class=" card-footer">
                            <a href="javascript:window.history.back();" class="btn btn-info">Back</a>
                            <button name="Done" class="btn btn-primary float-right" onclick="window.location='<?= base_url(); ?>/mountings'">Done</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        if (document.getElementById("tiresrow").value == "1")
            document.getElementById("tires_map").style.height = "150px";
        if (document.getElementById("tiresrow").value == "2")
            document.getElementById("tires_map").style.height = "250px";
        if (document.getElementById("tiresrow").value == "3")
            document.getElementById("tires_map").style.height = "350px";
        if (document.getElementById("tiresrow").value == "4")
            document.getElementById("tires_map").style.height = "490px";
        if (document.getElementById("tiresrow").value == "5")
            document.getElementById("tires_map").style.height = "600px";
        if (document.getElementById("tiresrow").value == "6")
            document.getElementById("tires_map").style.height = "700px";


        function delete_confirmation(id) {
            $('#modal_title').html('Delete Mounting');
            $('#modal_message').html('Are you sure want to delete this data?');
            $('#modal_type').attr("class", 'modal-content bg-danger');
            $('#modal_ok_link').attr("href", '<?= base_url(); ?>/mounting/delete_detail/' + id);
            $('#modal-form').modal();
        }

        function on_qr_success(qrcode) {
            $.get("<?= base_url(); ?>/tire/get_item_by_qrcode/" + qrcode, function(result) {
                var tire = JSON.parse(result.replace("[", "").replace("]", ""));
                try {
                    $("#tire_id").val(tire.id);
                } catch (e) {}
                try {
                    $("#tire_size").html(tire.size.name);
                    if (tire.size.name != "")
                        $("#li_tire_size").css("display", "block");
                } catch (e) {}
                try {
                    $("#tire_brand").html(tire.brand.name);
                    if (tire.brand.name != "")
                        $("#li_tire_brand").css("display", "block");
                } catch (e) {}
                try {
                    $("#tire_type").html(tire._type.name);
                    if (tire._type.name != "")
                        $("#li_tire_type").css("display", "block");
                } catch (e) {}
                try {
                    $("#tire_pattern").html(tire.pattern.name);
                    if (tire.pattern.name != "")
                        $("#li_tire_pattern").css("display", "block");
                } catch (e) {}
                try {
                    $("#tread_depth").html(tire.tread_depth);
                    if (tire.tread_depth != "")
                        $("#li_tread_depth").css("display", "block");
                } catch (e) {}
                try {
                    $("#psi").html(tire.psi);
                    if (tire.psi != "")
                        $("#li_psi").css("display", "block");
                } catch (e) {}
                try {
                    $("#tire_size_id").val(tire.size.id);
                } catch (e) {}
                try {
                    $("#tire_brand_id").val(tire.brand.id);
                } catch (e) {}
                try {
                    $("#tire_type_id").val(tire._type.id);
                } catch (e) {}
                try {
                    $("#tire_pattern_id").val(tire.pattern.id);
                } catch (e) {}
                try {
                    $("#otd").val(tire.tread_depth);
                } catch (e) {}
            });
        }

        function tire_position_clicked(tire_position_id) {
            $("#tire_position_id").val(tire_position_id);
            for (var i = 1; i < 30; i++) {
                try {
                    $("#tires_map_" + i).addClass("btn-info");
                    $("#tires_map_" + i).removeClass("btn-danger");
                } catch (ex) {}
            }
            $("#tires_map_" + tire_position_id).addClass("btn-danger");
            $("#tires_map_" + tire_position_id).removeClass("btn-info");
            $.get("<?= base_url(); ?>/tire_position/get_data/" + tire_position_id, function(result) {
                var tire_position = JSON.parse(result.replace("[", "").replace("]", ""));
                $("#tire_position").html(tire_position.name + " (" + tire_position.code + ")");
            });
        }
    </script>