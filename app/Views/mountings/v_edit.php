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
                            </div>
                            <div class="row" id="tires_map" style="display:none;">
                            </div>
                        </div>
                        <div class=" card-footer">
                            <a href="<?= base_url(); ?>/installations" class="btn btn-info">Back</a>
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
            document.getElementById("tires_map").style.display = "block";
            $.get("<?= base_url(); ?>/vehicle/get_tires_map/" + id, function(result) {
                var tires_map = "<div class='col-sm-4'>" + result + "</div>";
                $("#tires_map").html(tires_map);
                if ($("#tiresrow").val() == "1") $("#tires_map").height(100);
                if ($("#tiresrow").val() == "2") $("#tires_map").height(200);
                if ($("#tiresrow").val() == "3") $("#tires_map").height(300);
                if ($("#tiresrow").val() == "4") $("#tires_map").height(440);
                if ($("#tiresrow").val() == "5") $("#tires_map").height(550);
                if ($("#tiresrow").val() == "6") $("#tires_map").height(650);
            });

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