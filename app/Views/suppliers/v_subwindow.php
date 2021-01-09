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
                                    <th>Supplier Group</th>
                                    <th>Company Name</th>
                                    <th>PIC</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 0;
                                foreach ($suppliers as $supplier) :
                                    $no++;
                                ?>
                                    <tr>
                                        <td>
                                            <button class="btn btn-success btn-sm" onclick="subwindow_supplier_selected('<?= @$_GET['idx']; ?>','<?= $supplier->id; ?>','<?= $supplier->company_name; ?>')">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </td>
                                        <td><?= $supplier->id; ?></td>
                                        <td><?= $supplier_detail[$supplier->id]["supplier_group_id"]; ?></td>
                                        <td><?= $supplier->company_name; ?></td>
                                        <td><?= $supplier->pic; ?></td>
                                        <td><?= $supplier->email; ?></td>
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