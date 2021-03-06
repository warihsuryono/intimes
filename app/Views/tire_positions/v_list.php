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
                                                <label>Position Name</label>
                                                <input name="name" value="<?= @$_GET["name"]; ?>" type="text" class="form-control" placeholder="Position Name ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Position Code</label>
                                                <input name="code" value="<?= @$_GET["code"]; ?>" type="text" class="form-control" placeholder="Position Code ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Left/Right</label>
                                                <select class="form-control" name="left_right">
                                                    <option value=""></option>
                                                    <option value="left" <?= (@$_GET["left_right"] == "left") ? "selected" : ""; ?>>Left</option>
                                                    <option value="right" <?= (@$_GET["left_right"] == "right") ? "selected" : ""; ?>>Right</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Front/Rear</label>
                                                <select class="form-control" name="front_rear">
                                                    <option value=""></option>
                                                    <option value="front" <?= (@$_GET["front_rear"] == "front") ? "selected" : ""; ?>>Front</option>
                                                    <option value="rear" <?= (@$_GET["front_rear"] == "rear") ? "selected" : ""; ?>>Rear</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Inner/Outter</label>
                                                <select class="form-control" name="inner_outter">
                                                    <option value=""></option>
                                                    <option value="inner" <?= (@$_GET["inner_outter"] == "inner") ? "selected" : ""; ?>>Inner</option>
                                                    <option value="outter" <?= (@$_GET["inner_outter"] == "outter") ? "selected" : ""; ?>>Outter</option>
                                                </select>
                                            </div>
                                        </div>
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
                        <button class="btn btn-primary" onclick="window.location='<?= base_url(); ?>/tire_position/add';"><i class="fa fa-plus"></i></button>
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
                                    <th>Position Name</th>
                                    <th>Code</th>
                                    <th>Left/Right</th>
                                    <th>Front/Rear</th>
                                    <th>Inner/Outter</th>
                                    <th>Created At</th>
                                    <th>Created By</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = $startrow;
                                foreach ($tire_positions as $tire_position) :
                                    $no++;
                                ?>
                                    <tr>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="<?= base_url(); ?>/tire_position/edit/<?= $tire_position->id; ?>">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm" href="#" onclick="delete_confirmation(<?= $tire_position->id; ?>);">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                        <td><?= $no; ?></td>
                                        <td><?= $tire_position->name; ?></td>
                                        <td><?= $tire_position->code; ?></td>
                                        <td><?= $tire_position->left_right; ?></td>
                                        <td><?= $tire_position->front_rear; ?></td>
                                        <td><?= $tire_position->inner_outter; ?></td>
                                        <td><?= date("d-m-Y H:i:s", strtotime($tire_position->created_at)); ?></td>
                                        <td><?= $tire_position->created_by; ?></td>
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
        $('#modal_title').html('Delete Tire Position');
        $('#modal_message').html('Are you sure want to delete this data?');
        $('#modal_type').attr("class", 'modal-content bg-danger');
        $('#modal_ok_link').attr("href", '<?= base_url(); ?>/tire_position/delete/' + id);
        $('#modal-form').modal();
    }
</script>