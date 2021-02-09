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
                                <h4><b>Tire Info:</b></h4><br>
                                <ul class="list-group list-group-unbordered">
                                    <li class="list-group-item">
                                        <b>Tire Uniq code</b> <a class="pull-right" id="qrcode"></a>
                                    </li>
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
                            <div class="col-sm-4" style="display:none" id="installation_info">
                                <h4><b>Installation Info:</b></h4><br>
                                <ul class="list-group list-group-unbordered">
                                    <li class="list-group-item">
                                        <b>SPK No</b> <a class="pull-right" id="spk_no"></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>SPK At</b> <a class="pull-right" id="spk_at"></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Installed At</b> <a class="pull-right" id="installed_at"></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Vehicle Registration Plate</b> <a class="pull-right" id="vehicle_registration_plate"></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Tire Position</b> <a class="pull-right" id="tire_position"></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>KM</b> <a class="pull-right" id="km"></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Tread Depth</b> <a class="pull-right" id="tread_depth_installation"></a>
                                    </li>
                                    <li class="list-group-item">
                                        <img id="photo" height="150">
                                    </li>
                                    <li class="list-group-item">
                                        <button onclick="window.location='<?= base_url(); ?>/installation/edit/<?= @$installation->id; ?>';" class="btn btn-block btn-primary btn-lg"><i class="fa fa-search"></i></button>
                                    </li>
                                </ul>
                                <br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <button onclick="window.location='<?= base_url(); ?>/installation/add?qrcode=<?= $qrcode; ?>';" id="btn_installation" class="btn btn-block btn-primary btn-lg">Pemasangan</button><br>
                                <button onclick="window.location='<?= base_url(); ?>/checking/add?qrcode=<?= $qrcode; ?>';" class="btn btn-block btn-primary btn-lg">Pengecekan</button><br>
                                <button onclick="window.location='<?= base_url(); ?>/claim/add?qrcode=<?= $qrcode; ?>';" class="btn btn-block btn-primary btn-lg">Klaim</button><br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    setTimeout(function() {
        $.get("<?= base_url(); ?>/tire/get_item_by_qrcode/<?= $qrcode; ?>", function(result) {
            var tire = JSON.parse(result.replace("[", "").replace("]", ""));
            try {
                $("#tire_id").val(tire.id);
            } catch (e) {}
            try {
                $("#qrcode").html("<?= $qrcode; ?>");
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
            $("#tire_descriptions").fadeIn();
        });

        $.get("<?= base_url(); ?>/installation/get_item_by_qrcode/<?= $qrcode; ?>", function(result) {
            var installation = JSON.parse(result.replace("[", "").replace("]", ""));
            try {
                $("#spk_no").html(installation.spk_no);
            } catch (e) {}
            try {
                $("#spk_at").html(installation.spk_at);
            } catch (e) {}
            try {
                $("#installed_at").html(installation.installed_at);
            } catch (e) {}
            try {
                $("#vehicle_registration_plate").html(installation.vehicle_registration_plate);
            } catch (e) {}
            try {
                $("#tire_position").html(installation.tire_position.name);
            } catch (e) {}
            try {
                $("#km").html(installation.km);
            } catch (e) {}
            try {
                $("#tread_depth_installation").html(installation.tread_depth);
            } catch (e) {}
            try {
                $("#photo").attr("src", "<?= base_url(); ?>/dist/upload/installations/" + installation.photo);
            } catch (e) {}
            $("#installation_info").fadeIn();
            $("#btn_installation").fadeOut();
        });
    }, 200);
</script>