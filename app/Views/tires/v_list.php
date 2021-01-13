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
                                                    <input id="qrcode" name="qrcode" value="<?= @$_GET["qrcode"]; ?>" type="text" class="form-control" placeholder="QR Code ...">
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-info btn-flat" onclick="qrcode_reader('qrcode');"><i class="fa fa-barcode"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Serial No</label>
                                                <input name="serialno" value="<?= @$_GET["serialno"]; ?>" type="text" class="form-control" placeholder="Serial No ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Vulkanisir</label>
                                                <select name="is_retread" class="form-control">
                                                    <option value=""></option>
                                                    <option value="1" <?= (@$_GET["is_retread"] == "1") ? "selected" : ""; ?>>Yes</option>
                                                    <option value="2" <?= (@$_GET["is_retread"] == "2") ? "selected" : ""; ?>>No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Tire Size</label>
                                                <select name="tire_size_id" class="form-control">
                                                    <option value="">-- Select Tire Size --</option>
                                                    <?php foreach ($tire_sizes as $tire_size) : ?>
                                                        <option value="<?= $tire_size->id; ?>" <?= (@$_GET["tire_size_id"] == $tire_size->id) ? "selected" : ""; ?>><?= $tire_size->name; ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Tire Brand</label>
                                                <select name="tire_brand_id" class="form-control">
                                                    <option value="">-- Select Tire Brand --</option>
                                                    <?php foreach ($tire_brands as $tire_brand) : ?>
                                                        <option value="<?= $tire_brand->id; ?>" <?= (@$_GET["tire_brand_id"] == $tire_brand->id) ? "selected" : ""; ?>><?= $tire_brand->name; ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Tire Type</label>
                                                <select name="tire_type_id" class="form-control">
                                                    <option value="">-- Select Tire Type --</option>
                                                    <?php foreach ($tire_types as $tire_type) : ?>
                                                        <option value="<?= $tire_type->id; ?>" <?= (@$_GET["tire_type_id"] == $tire_type->id) ? "selected" : ""; ?>><?= $tire_type->name; ?></option>
                                                    <?php endforeach ?>
                                                </select>
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
                        <button class="btn btn-primary" onclick="window.location='<?= base_url(); ?>/tire/add';"><i class="fa fa-plus"></i></button>
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
                                    <th>QrCode</th>
                                    <th>Vulkanisir</th>
                                    <th>Size</th>
                                    <th>Brand</th>
                                    <th>Type</th>
                                    <th>Tread Depth</th>
                                    <th>Pattern</th>
                                    <th>Psi</th>
                                    <th>Remark</th>
                                    <th>Created At</th>
                                    <th>Created By</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = $startrow;
                                foreach ($tires as $tire) :
                                    $no++;
                                ?>
                                    <tr>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="<?= base_url(); ?>/tire/edit/<?= $tire->id; ?>">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm" href="#" onclick="delete_confirmation(<?= $tire->id; ?>);">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                        <td><?= $no; ?></td>
                                        <td><?= $tire->id; ?></td>
                                        <td><?= $tire->qrcode; ?></td>
                                        <td><?= ($tire->is_retread == "1") ? "Yes" : "No"; ?></td>
                                        <td><?= $tire_detail[$tire->id]["tire_size"]->name; ?></td>
                                        <td><?= $tire_detail[$tire->id]["tire_brand"]->name; ?></td>
                                        <td><?= $tire_detail[$tire->id]["tire_type"]->name; ?></td>
                                        <td><?= $tire->tread_depth; ?></td>
                                        <td><?= $tire->pattern; ?></td>
                                        <td><?= $tire->psi; ?></td>
                                        <td><?= $tire->remark; ?></td>
                                        <td><?= date("d-m-Y H:i:s", strtotime($tire->created_at)); ?></td>
                                        <td><?= $tire->created_by; ?></td>
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
        $('#modal_title').html('Delete Tire');
        $('#modal_message').html('Are you sure want to delete this data?');
        $('#modal_type').attr("class", 'modal-content bg-danger');
        $('#modal_ok_link').attr("href", '<?= base_url(); ?>/tire/delete/' + id);
        $('#modal-form').modal();
    }
</script>