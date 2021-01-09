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
                                                <label>Stock Control No</label>
                                                <input name="stock_control_no" value="<?= @$_GET["stock_control_no"]; ?>" type="text" class="form-control" placeholder="Stock Control No ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Stock Control At</label>
                                                <input name="stock_control_at" value="<?= @$_GET["stock_control_at"]; ?>" type="date" class="form-control" placeholder="Stock Control At ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Notes</label>
                                                <input name="description" value="<?= @$_GET["description"]; ?>" type="text" class="form-control" placeholder="Notes ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Created By</label>
                                                <input name="created_by" value="<?= @$_GET["created_by"]; ?>" type="text" class="form-control" placeholder="Created By ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Approved</label>
                                                <select name="is_approved" class="form-control">
                                                    <option value="">-- Is Approved --</option>
                                                    <option value="1" <?= (@$_GET["is_approved"] == "1") ? "selected" : ""; ?>>Yes</option>
                                                    <option value="0" <?= (@$_GET["is_approved"] == "0") ? "selected" : ""; ?>>No</option>
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
                        <button class="btn btn-primary" onclick="window.location='<?= base_url(); ?>/stock_control/add';"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
                <div class="card">
                    <!--PAGING -->
                    <?php if ($numrow > MAX_ROW) : ?>
                        <?php if (!isset($_GET["page"])) $_GET["page"] = 1; ?>
                        <div class="card-header">
                            <div class="card-tools">
                                <div class="dataTables_paginate paging_simple_numbers">
                                    <ul class="pagination">
                                        <li class="paginate_button page-item previous"><a onclick="$('#page').val('1');$('#filter_form').submit();" href="#" class="page-link">First</a></li>
                                        <?php for ($page = 1; $page <= $maxpage; $page++) : ?>
                                            <li class="paginate_button page-item <?= ($_GET["page"] == $page) ? "active" : "" ?>"><a onclick="$('#page').val('<?= $page; ?>');$('#filter_form').submit();" href="#" class="page-link"><?= $page; ?></a></li>
                                        <?php endfor ?>
                                        <li class="paginate_button page-item next"><a onclick="$('#page').val('<?= $maxpage; ?>');$('#filter_form').submit();" href="#" class="page-link">Last</a></li>
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
                                    <th>Stock Control No</th>
                                    <th>Stock Control At</th>
                                    <th>Created At</th>
                                    <th>Created By</th>
                                    <th>Approved</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = $startrow;
                                foreach ($stock_controls as $stock_control) :
                                    $no++;
                                ?>
                                    <tr>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="<?= base_url(); ?>/stock_control/view/<?= $stock_control->id; ?>">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a class="btn btn-info btn-sm" href="<?= base_url(); ?>/stock_control/edit/<?= $stock_control->id; ?>">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm" href="#" onclick="delete_confirmation(<?= $stock_control->id; ?>);">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                        <td><?= $no; ?></td>
                                        <td><?= $stock_control->stock_control_no; ?></td>
                                        <td><?= $stock_control->stock_control_at; ?></td>
                                        <td><?= date("d-m-Y H:i:s", strtotime($stock_control->created_at)); ?></td>
                                        <td><?= $stock_control->created_by; ?></td>
                                        <td><?= ($stock_control->is_approved) ? "<i class='btn btn-success'>Yes</i>" : "<i class='btn btn-danger'>No</i>"; ?></td>
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
        $('#modal_title').html('Delete Stock Control');
        $('#modal_message').html('Are you sure want to delete this data?');
        $('#modal_type').attr("class", 'modal-content bg-danger');
        $('#modal_ok_link').attr("href", '<?= base_url(); ?>/stock_control/delete/' + id);
        $('#modal-form').modal();
    }
</script>