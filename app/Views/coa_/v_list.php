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
                                                <label>COA</label>
                                                <input name="coa" value="<?= @$_GET["coa"]; ?>" type="text" class="form-control" placeholder="COA ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Parent COA</label>
                                                <select name="parent_coa" class="form-control">
                                                    <option value="">-- Parent COA --</option>
                                                    <?php foreach ($coas as $coa) : ?>
                                                        <option value="<?= $coa->coa; ?>" <?= (@$_GET["parent_coa"] == $coa->coa) ? "selected" : ""; ?>><?= $coa->coa; ?> -- <?= $coa->description; ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <input name="description" value="<?= @$_GET["description"]; ?>" type="text" class="form-control" placeholder="Description ...">
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
                        <button class="btn btn-primary" onclick="window.location='<?= base_url(); ?>/coa/add';"><i class="fa fa-plus"></i></button>
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
                                    <th>COA</th>
                                    <th>PARENT</th>
                                    <th>Description</th>
                                    <th>Created At</th>
                                    <th>Created By</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = $startrow;
                                foreach ($coas as $coa) :
                                    $no++;
                                ?>
                                    <tr>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="<?= base_url(); ?>/coa/edit/<?= $coa->id; ?>">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm" href="#" onclick="delete_confirmation(<?= $coa->id; ?>);">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                        <td><?= $no; ?></td>
                                        <td><?= $coa->coa; ?></td>
                                        <td><?= $coa_detail[$coa->id]["parent_coa"]; ?></td>
                                        <td><?= $coa->description; ?></td>
                                        <td><?= date("d-m-Y H:i:s", strtotime($coa->created_at)); ?></td>
                                        <td><?= $coa->created_by; ?></td>
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
        $('#modal_title').html('Delete COA');
        $('#modal_message').html('Are you sure want to delete this data?');
        $('#modal_type').attr("class", 'modal-content bg-danger');
        $('#modal_ok_link').attr("href", '<?= base_url(); ?>/coa/delete/' + id);
        $('#modal-form').modal();
    }
</script>