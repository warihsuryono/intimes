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
                                                <label>Invoice Number</label>
                                                <input name="invoice_no" value="<?= @$_GET["invoice_no"]; ?>" type="text" class="form-control" placeholder="Invoice Number ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Supplier PO Number</label>
                                                <input name="po_no" value="<?= @$_GET["quotation_no"]; ?>" type="text" class="form-control" placeholder="Quotation Number ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Supplier</label>
                                                <select name="supplier_id" class="form-control">
                                                    <option value="">-- Supplier --</option>
                                                    <?php foreach ($suppliers as $supplier) : ?>
                                                        <option value="<?= $supplier->id; ?>" <?= (@$_GET["supplier_id"] == $supplier->id) ? "selected" : ""; ?>><?= $supplier->company_name; ?></option>
                                                    <?php endforeach ?>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Issued At</label>
                                                <input name="issued_at" value="<?= @$_GET["issued_at"]; ?>" type="date" class="form-control" placeholder="Issued At ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Due Date</label>
                                                <input name="due_date_at" value="<?= @$_GET["due_date_at"]; ?>" type="date" class="form-control" placeholder="Due Date ...">
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
                                                <label>Payment Status</label>
                                                <select name="invoice_status_id" class="form-control">
                                                    <option value="">-- Status --</option>
                                                    <?php foreach ($supplier_invoice_statuses as $supplier_invoice_status) : ?>
                                                        <option value="<?= $supplier_invoice_status->id; ?>" <?= (@$_GET["invoice_status_id"] == $supplier_invoice_status->id) ? "selected" : ""; ?>><?= $supplier_invoice_status->name; ?></option>
                                                    <?php endforeach ?>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Created By</label>
                                                <input name="created_by" value="<?= @$_GET["created_by"]; ?>" type="text" class="form-control" placeholder="Created By ...">
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
                        <button class="btn btn-primary" onclick="window.location='<?= base_url(); ?>/supplier_invoice/add';"><i class="fa fa-plus"></i></button>
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
                                    <th>Invoice Number</th>
                                    <th>PO Number</th>
                                    <th>Supplier</th>
                                    <th>Issued At</th>
                                    <th>Due Date</th>
                                    <th>Payment Type</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Created By</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = $startrow;
                                foreach ($supplier_invoices as $supplier_invoice) :
                                    $no++;
                                ?>
                                    <tr>
                                        <td>
                                            <a class="btn btn-primary btn-sm" href="<?= base_url(); ?>/supplier_invoice/view/<?= $supplier_invoice->id; ?>">
                                                <i class="fas fa-search"></i>
                                            </a>
                                            <a class="btn btn-info btn-sm" href="<?= base_url(); ?>/supplier_invoice/edit/<?= $supplier_invoice->id; ?>">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm" href="#" onclick="delete_confirmation(<?= $supplier_invoice->id; ?>);">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                        <td><?= $no; ?></td>
                                        <td><?= $supplier_invoice->id; ?></td>
                                        <td><?= $supplier_invoice->invoice_no; ?></td>
                                        <td><?= $supplier_invoice->po_no; ?></td>
                                        <td><?= $supplier_invoice_detail[$supplier_invoice->id]["supplier"]; ?></td>
                                        <td><?= date("d-m-Y", strtotime($supplier_invoice->issued_at)); ?></td>
                                        <td><?= date("d-m-Y", strtotime($supplier_invoice->due_date_at)); ?></td>
                                        <td><?= $supplier_invoice_detail[$supplier_invoice->id]["payment_type"]; ?></td>
                                        <td align="right"><?= number_format($supplier_invoice->total, 0, ",", "."); ?></td>
                                        <td><?= $supplier_invoice_detail[$supplier_invoice->id]["status"]; ?></td>
                                        <td><?= date("d-m-Y H:i:s", strtotime($supplier_invoice->created_at)); ?></td>
                                        <td><?= $supplier_invoice->created_by; ?></td>
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
        $('#modal_title').html('Delete Supplier PO');
        $('#modal_message').html('Are you sure want to delete this data?');
        $('#modal_type').attr("class", 'modal-content bg-danger');
        $('#modal_ok_link').attr("href", '<?= base_url(); ?>/supplier_invoice/delete/' + id);
        $('#modal-form').modal();
    }
</script>