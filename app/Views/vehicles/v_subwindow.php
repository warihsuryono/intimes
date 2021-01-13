<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body table-responsive p-0">
                        <table class="table table-head-fixed text-nowrap table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Id</th>
                                    <th>Registration Plate</th>
                                    <th>Brand</th>
                                    <th>Type</th>
                                    <th>Model</th>
                                    <th>Modi No</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 0;
                                foreach ($vehicles as $vehicle) :
                                    $no++;
                                ?>
                                    <tr>
                                        <td>
                                            <button class="btn btn-success btn-sm" onclick="subwindow_vehicle_selected('<?= @$_GET['idx']; ?>','<?= $vehicle->id; ?>','<?= $vehicle->registration_plate; ?>')">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </td>
                                        <td><?= $vehicle->id; ?></td>
                                        <td><?= $vehicle->registration_plate; ?></td>
                                        <td><?= $vehicle_detail[$vehicle->id]["vehicle_brand"]->name; ?></td>
                                        <td><?= $vehicle_detail[$vehicle->id]["vehicle_type"]->name; ?></td>
                                        <td><?= $vehicle->model; ?></td>
                                        <td><?= $vehicle->modi_no; ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>