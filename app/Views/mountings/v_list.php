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
                                                <label>QR Code</label>
                                                <div class="input-group">
                                                    <input id="code" name="code" value="<?= @$_GET["code"]; ?>" type="text" class="form-control" placeholder="QR Code ...">
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-info btn-flat" onclick="qrcode_reader('code');"><i class="fa fa-barcode"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Customer Name</label>
                                                <input name="customer_name" value="<?= @$_GET["customer_name"]; ?>" type="text" class="form-control" placeholder="Customer Name ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Vehicle Registration Plate</label>
                                                <input name="vehicle_registration_plate" value="<?= @$_GET["vehicle_registration_plate"]; ?>" type="text" class="form-control" placeholder="Vehicle Registration Plate ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>SPK No</label>
                                                <input name="spk_no" value="<?= @$_GET["spk_no"]; ?>" type="text" class="form-control" placeholder="SPK No ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>SPK At</label>
                                                <input name="SPK At" value="<?= @$_GET["spk_at"]; ?>" type="date" class="form-control" placeholder="SPK At ...">
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
                        <button class="btn btn-primary" onclick="window.location='<?= base_url(); ?>/mounting/add';"><i class="fa fa-plus"></i></button>
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
                                    <th>Customer</th>
                                    <th>SPK No</th>
                                    <th>SPK Date</th>
                                    <th>Mounting at</th>
                                    <th>Reg Plate</th>
                                    <th>Position</th>
                                    <th>Uniq Code</th>
                                    <th>Size</th>
                                    <th>Brand</th>
                                    <th>Type</th>
                                    <th>Pattern</th>
                                    <th>Created At</th>
                                    <th>Created By</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = $startrow;
                                foreach ($mounting_details as $_mounting_detail) :
                                    $no++;
                                ?>
                                    <tr>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="<?= base_url(); ?>/mounting/add/<?= $_mounting_detail->mounting_id; ?>">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm" href="#" onclick="delete_confirmation(<?= $_mounting_detail->mounting_id; ?>);">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                        <td><?= $mountings[$_mounting_detail->mounting_id]->customer_name; ?></td>
                                        <td><?= $mountings[$_mounting_detail->mounting_id]->spk_no; ?></td>
                                        <td><?= date("d-m-Y", strtotime($mountings[$_mounting_detail->mounting_id]->spk_at)); ?></td>
                                        <td><?= date("d-m-Y", strtotime($mountings[$_mounting_detail->mounting_id]->mounting_at)); ?></td>
                                        <td><?= $mountings[$_mounting_detail->mounting_id]->vehicle_registration_plate; ?></td>
                                        <td><?= $mounting_detail[$_mounting_detail->id]["tire_position"]->name; ?></td>
                                        <td><?= $_mounting_detail->code; ?></td>
                                        <td><?= $mounting_detail[$_mounting_detail->id]["tire_size"]->name; ?></td>
                                        <td><?= $mounting_detail[$_mounting_detail->id]["tire_brand"]->name; ?></td>
                                        <td><?= $mounting_detail[$_mounting_detail->id]["tire_type"]->name; ?></td>
                                        <td><?= $mounting_detail[$_mounting_detail->id]["tire_pattern"]->name; ?></td>
                                        <td><?= date("d-m-Y H:i:s", strtotime($mountings[$_mounting_detail->mounting_id]->created_at)); ?></td>
                                        <td><?= $mountings[$_mounting_detail->mounting_id]->created_by; ?></td>
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
        $('#modal_title').html('Delete Mounting');
        $('#modal_message').html('Are you sure want to delete this data?');
        $('#modal_type').attr("class", 'modal-content bg-danger');
        $('#modal_ok_link').attr("href", '<?= base_url(); ?>/mounting/delete/' + id);
        $('#modal-form').modal();
    }
</script>