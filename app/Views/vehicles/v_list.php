<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <!--FILTER -->
                <div class="card collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title">Filter</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0" style="display: none;">
                        <div class="d-md-flex">
                            <div class="p-1 flex-fill" style="overflow: hidden">
                                <form method="GET" id="filter_form">
                                    <input type="hidden" id="page" name="page" value="1">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Customer</label>
                                                <input name="customer_name" value="<?= @$_GET["customer_name"]; ?>" type="text" class="form-control" placeholder="Customer Name ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Registration Plate</label>
                                                <input name="registration_plate" value="<?= @$_GET["registration_plate"]; ?>" type="text" class="form-control" placeholder="Registration Plate ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Vehicle Brand</label>
                                                <select name="vehicle_brand_id" class="form-control">
                                                    <option value="">-- Select Vehicle Brand --</option>
                                                    <?php foreach ($vehicle_brands as $vehicle_brand) : ?>
                                                        <option value="<?= $vehicle_brand->id; ?>" <?= (@$_GET["vehicle_brand_id"] == $vehicle_brand->id) ? "selected" : ""; ?>><?= $vehicle_brand->name; ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Vehicle Type</label>
                                                <select name="vehicle_type_id" class="form-control">
                                                    <option value="">-- Select Vehicle Type --</option>
                                                    <?php foreach ($vehicle_types as $vehicle_type) : ?>
                                                        <option value="<?= $vehicle_type->id; ?>" <?= (@$_GET["vehicle_type_id"] == $vehicle_type->id) ? "selected" : ""; ?>><?= $vehicle_type->name; ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Model</label>
                                                <input name="model" value="<?= @$_GET["model"]; ?>" type="text" class="form-control" placeholder="Model ...">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 text-right">
                                            <input type="reset" onclick="window.location='?';" class="btn btn-default" value="Reset">
                                            <input type="submit" class="btn btn-primary" value="Search">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--END FILTER -->
                <div class="row" style="margin-bottom:10px;">
                    <div class="col-2">
                        <button class="btn btn-primary" onclick="window.location='<?= base_url(); ?>/vehicle/add';"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
                <div class="card">
                    <!--PAGING -->
                    <?php if ($numrow > MAX_ROW) : ?>
                        <?php if (!isset($_GET["page"])) $_GET["page"] = 1; ?>
                        <div class="card-header">
                            <div class="card-tools">
                                <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                                    <ul class="pagination">
                                        <li class="paginate_button page-item previous" id="example2_previous"><a onclick="$('#page').val('1');$('#filter_form').submit();" href="#" aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link">First</a></li>
                                        <?php for ($page = 1; $page <= $maxpage; $page++) : ?>
                                            <li class="paginate_button page-item <?= ($_GET["page"] == $page) ? "active" : "" ?>"><a onclick="$('#page').val('<?= $page; ?>');$('#filter_form').submit();" href="#" aria-controls="example2" data-dt-idx="1" tabindex="0" class="page-link"><?= $page; ?></a></li>
                                        <?php endfor ?>
                                        <li class="paginate_button page-item next" id="example2_next"><a onclick="$('#page').val('<?= $maxpage; ?>');$('#filter_form').submit();" href="#" aria-controls="example2" data-dt-idx="7" tabindex="0" class="page-link">Last</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                    <!--END PAGING -->
                    <div class="card-body table-responsive p-0" style="height: 700px;">
                        <table class="table table-head-fixed text-nowrap table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>No</th>
                                    <th>Id</th>
                                    <th>Customer</th>
                                    <th>Registration Plate</th>
                                    <th>Brand</th>
                                    <th>Type</th>
                                    <th>Model</th>
                                    <th>Body No</th>
                                    <th>Created At</th>
                                    <th>Created By</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = $startrow;
                                foreach ($vehicles as $vehicle) :
                                    $no++;
                                ?>
                                    <tr>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="<?= base_url(); ?>/vehicle/edit/<?= $vehicle->id; ?>">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm" href="#" onclick="delete_confirmation(<?= $vehicle->id; ?>);">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                        <td><?= $no; ?></td>
                                        <td><?= $vehicle->id; ?></td>
                                        <td><?= $vehicle->customer_name; ?></td>
                                        <td><?= $vehicle->registration_plate; ?></td>
                                        <td><?= $vehicle_detail[$vehicle->id]["vehicle_brand"]->name; ?></td>
                                        <td><?= $vehicle_detail[$vehicle->id]["vehicle_type"]->name; ?></td>
                                        <td><?= $vehicle->model; ?></td>
                                        <td><?= $vehicle->body_no; ?></td>
                                        <td><?= date("d-m-Y H:i:s", strtotime($vehicle->created_at)); ?></td>
                                        <td><?= $vehicle->created_by; ?></td>
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
<script>
    function delete_confirmation(id) {
        $('#modal_title').html('Delete Vehicle');
        $('#modal_message').html('Are you sure want to delete this data?');
        $('#modal_type').attr("class", 'modal-content bg-danger');
        $('#modal_ok_link').attr("href", '<?= base_url(); ?>/vehicle/delete/' + id);
        $('#modal-form').modal();
    }
</script>