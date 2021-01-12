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
                                                <label>Size Name</label>
                                                <input name="name" value="<?= @$_GET["name"]; ?>" type="text" class="form-control" placeholder="Size Name ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Diameter</label>
                                                <input name="diameter" value="<?= @$_GET["diameter"]; ?>" type="number" step="0.1" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Width</label>
                                                <input name="width" value="<?= @$_GET["width"]; ?>" type="number" step="0.1" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Wheel</label>
                                                <input name="wheel" value="<?= @$_GET["wheel"]; ?>" type="number" step="0.1" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Sidewall</label>
                                                <input name="sidewall" value="<?= @$_GET["sidewall"]; ?>" type="number" step="0.1" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Circumference</label>
                                                <input name="circumference" value="<?= @$_GET["circumference"]; ?>" type="number" step="0.1" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Revolutions Per Mile</label>
                                                <input name="revs_mile" value="<?= @$_GET["revs_mile"]; ?>" type="number" step="0.1" class="form-control">
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
                        <button class="btn btn-primary" onclick="window.location='<?= base_url(); ?>/tire_size/add';"><i class="fa fa-plus"></i></button>
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
                                    <th>Size Name</th>
                                    <th>Diameter</th>
                                    <th>Width</th>
                                    <th>Wheel</th>
                                    <th>Sidewall</th>
                                    <th>Circumference</th>
                                    <th>Revs_mile</th>
                                    <th>Created At</th>
                                    <th>Created By</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = $startrow;
                                foreach ($tire_sizes as $tire_size) :
                                    $no++;
                                ?>
                                    <tr>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="<?= base_url(); ?>/tire_size/edit/<?= $tire_size->id; ?>">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm" href="#" onclick="delete_confirmation(<?= $tire_size->id; ?>);">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                        <td><?= $no; ?></td>
                                        <td><?= $tire_size->id; ?></td>
                                        <td><?= $tire_size->name; ?></td>
                                        <td><?= $tire_size->diameter; ?></td>
                                        <td><?= $tire_size->width; ?></td>
                                        <td><?= $tire_size->wheel; ?></td>
                                        <td><?= $tire_size->sidewall; ?></td>
                                        <td><?= $tire_size->circumference; ?></td>
                                        <td><?= $tire_size->revs_mile; ?></td>
                                        <td><?= date("d-m-Y H:i:s", strtotime($tire_size->created_at)); ?></td>
                                        <td><?= $tire_size->created_by; ?></td>
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
        $('#modal_title').html('Delete Tire Size');
        $('#modal_message').html('Are you sure want to delete this data?');
        $('#modal_type').attr("class", 'modal-content bg-danger');
        $('#modal_ok_link').attr("href", '<?= base_url(); ?>/tire_size/delete/' + id);
        $('#modal-form').modal();
    }
</script>