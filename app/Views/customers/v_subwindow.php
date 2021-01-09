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
                                    <th>Industry Category</th>
                                    <th>Company Name</th>
                                    <th>Prospect</th>
                                    <th>PIC</th>
                                    <th>PIC Phone</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 0;
                                foreach ($customers as $customer) :
                                    $no++;
                                ?>
                                    <tr>
                                        <td>
                                            <button class="btn btn-success btn-sm" onclick="subwindow_customer_selected('<?= @$_GET['idx']; ?>','<?= $customer->id; ?>','<?= $customer->company_name; ?>')">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </td>
                                        <td><?= $customer->id; ?></td>
                                        <td><?= $customer_detail[$customer->id]["industry_category_id"]; ?></td>
                                        <td><?= $customer->company_name; ?></td>
                                        <td><?= $customer_detail[$customer->id]["customer_prospect_id"]; ?></td>
                                        <td><?= $customer->pic; ?></td>
                                        <td><?= $customer->pic_phone; ?></td>
                                        <td><?= $customer->email; ?></td>
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