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
                            <div class="col-sm-12">
                                <button onclick="window.location='<?= base_url(); ?>/installation/add?qrcode=<?= $qrcode; ?>';" class="btn btn-block btn-primary btn-lg">Pemasangan</button><br>
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
    }, 200);
</script>