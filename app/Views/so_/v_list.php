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
                                                <label>Sales Order Number</label>
                                                <input name="so_no" value="<?= @$_GET["so_no"]; ?>" type="text" class="form-control" placeholder="Sales Order Number ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Quotation Number</label>
                                                <input name="quotation_no" value="<?= @$_GET["quotation_no"]; ?>" type="text" class="form-control" placeholder="Quotation Number ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Customer</label>
                                                <select name="customer_id" class="form-control">
                                                    <option value="">-- Customer --</option>
                                                    <?php foreach ($customers as $customer) : ?>
                                                        <option value="<?= $customer->id; ?>" <?= (@$_GET["customer_id"] == $customer->id) ? "selected" : ""; ?>><?= $customer->company_name; ?></option>
                                                    <?php endforeach ?>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>SO Received At</label>
                                                <input name="so_received_at" value="<?= @$_GET["so_received_at"]; ?>" type="date" class="form-control" placeholder="SO Received At ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <input name="description" value="<?= @$_GET["description"]; ?>" type="text" class="form-control" placeholder="Description ...">
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
                        <button class="btn btn-primary" onclick="window.location='<?= base_url(); ?>/so/add';"><i class="fa fa-plus"></i></button>
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
                                    <th>Id</th>
                                    <th>SO Number</th>
                                    <th>Quotation No</th>
                                    <th>Customer</th>
                                    <th>SO Received at</th>
                                    <th>Payment Type</th>
                                    <th>Total</th>
                                    <th>Created At</th>
                                    <th>Created By</th>
                                    <th>Approved</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = $startrow;
                                foreach ($so_ as $so) :
                                    $no++;
                                ?>
                                    <tr>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="<?= base_url(); ?>/so/view/<?= $so->id; ?>">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a class="btn btn-info btn-sm" href="<?= base_url(); ?>/so/edit/<?= $so->id; ?>">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a class="btn btn-info btn-sm" href="<?= base_url(); ?>/invoice/add?so_no=<?= $so->so_no; ?>" title="Create Invoice">
                                                <i class="fas fa-file-invoice nav-icon"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm" href="#" onclick="delete_confirmation(<?= $so->id; ?>);">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                        <td><?= $no; ?></td>
                                        <td><?= $so->id; ?></td>
                                        <td><?= $so->so_no; ?></td>
                                        <td><?= $so->quotation_no; ?></td>
                                        <td><?= $so_detail[$so->id]["customer"]; ?></td>
                                        <td><?= date("d-m-Y", strtotime($so->so_received_at)); ?></td>
                                        <td><?= $so_detail[$so->id]["payment_type"]; ?></td>
                                        <td align="right"><?= $_this->amountformat($so->total); ?></td>
                                        <td><?= date("d-m-Y H:i:s", strtotime($so->created_at)); ?></td>
                                        <td><?= $so->created_by; ?></td>
                                        <td><?= ($so->is_approved) ? "<i class='btn btn-success'>Yes</i>" : "<i class='btn btn-danger'>No</i>"; ?></td>
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
        $('#modal_title').html('Delete Sales Order');
        $('#modal_message').html('Are you sure want to delete this data?');
        $('#modal_type').attr("class", 'modal-content bg-danger');
        $('#modal_ok_link').attr("href", '<?= base_url(); ?>/so/delete/' + id);
        $('#modal-form').modal();
    }
</script>