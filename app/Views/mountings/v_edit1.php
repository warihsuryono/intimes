<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <form role="form" id="mainform" method="POST">
                        <?= $_form->hidden("tire_position_id"); ?>
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
                                    <div class="form-group" id="tires_map" style="display:none;">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Customer</label>
                                        <?= $_form->input("customer_name", "", "readonly"); ?>
                                    </div>
                                </div>
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
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Mounting Date</label>
                                        <?= $_form->input("mounting_at", "", "type='date' required"); ?>
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
                    </form>
                    <div class=" card-footer">
                        <a href="<?= base_url(); ?>/mountings" class="btn btn-info">Back</a>
                        <button type="submit" name="Next" class="btn btn-primary float-right">Next</button>
                    </div>
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
                if ($("#tiresrow").val() == "1") {
                    $("#tires_map").height(150);
                    $("#tires_map").html(tires_map + "<h3 style='position:absolute;top:160px;'><b>" + $("#vehicle_type_name").val() + "</b></h3>");
                }
                if ($("#tiresrow").val() == "2") {
                    $("#tires_map").height(250);
                    $("#tires_map").html(tires_map + "<h3 style='position:absolute;top:260px;'><b>" + $("#vehicle_type_name").val() + "</b></h3>");
                }
                if ($("#tiresrow").val() == "3") {
                    $("#tires_map").height(350);
                    $("#tires_map").html(tires_map + "<h3 style='position:absolute;top:360px;'><b>" + $("#vehicle_type_name").val() + "</b></h3>");
                }
                if ($("#tiresrow").val() == "4") {
                    $("#tires_map").height(490);
                    $("#tires_map").html(tires_map + "<h3 style='position:absolute;top:500px;'><b>" + $("#vehicle_type_name").val() + "</b></h3>");
                }
                if ($("#tiresrow").val() == "5") {
                    $("#tires_map").height(600);
                    $("#tires_map").html(tires_map + "<h3 style='position:absolute;top:610px;'><b>" + $("#vehicle_type_name").val() + "</b></h3>");
                }
                if ($("#tiresrow").val() == "6") {
                    $("#tires_map").height(700);
                    $("#tires_map").html(tires_map + "<h3 style='position:absolute;top:710px;'><b>" + $("#vehicle_type_name").val() + "</b></h3>");
                }
                $("#customer_name").val($("#customer_company_name").val());
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

    function tire_position_clicked(tire_position_id) {
        $("#tire_position_id").val(tire_position_id);
        for (var i = 1; i < 30; i++) {
            try {
                $("#tires_map_" + i).addClass("btn-info");
                $("#tires_map_" + i).removeClass("btn-success");
            } catch (ex) {}
        }
        $("#tires_map_" + tire_position_id).addClass("btn-success");
        $("#tires_map_" + tire_position_id).removeClass("btn-info");
    }
</script>