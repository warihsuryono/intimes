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
                                        <b>Customer</b> <a class="pull-right"><?= $mounting->customer_name; ?></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Registration Plate</b> <a class="pull-right"><?= $vehicle->registration_plate; ?></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Type</b> <a class="pull-right"><?= $vehicle_type; ?></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Brand</b> <a class="pull-right"><?= $vehicle_brand; ?></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Model</b> <a class="pull-right"><?= $vehicle->model; ?></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Body No</b> <a class="pull-right"><?= $vehicle->body_no; ?></a>
                                    </li>
                                </ul> <br>
                                <div class="form-group">
                                    <button class="btn btn-primary" style="float: right;" onclick="window.location='<?= base_url(); ?>/checking/executions/<?= $mounting->id; ?>/2';">Start Checking >> </button>
                                </div>
                            </div>
                            <div class="col-sm-1">
                            </div>
                            <div class="col-sm-4">
                                <div style="position:relative;top:20px;height:700px;">
                                    <?= $tires_map; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>