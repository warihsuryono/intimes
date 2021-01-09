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
                                                <label>Date</label>
                                                <input name="tanggal" value="<?= @$_GET["tanggal"]; ?>" type="date" class="form-control" placeholder="Date ...">
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

                <div class="invoice p-3 mb-3">
                    <!-- title row -->
                    <div class="row">
                        <div class="col-12">
                            <b class="float-right">Date : <?= date("d F Y", strtotime($tanggal)); ?></b>
                        </div>
                        <!-- /.col -->
                    </div>

                    <!-- Table row -->
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>No</th>
                                        <th>Customer Code</th>
                                        <th>Customer</th>
                                        <th>Begining Balance</th>
                                        <th>Sales</th>
                                        <th>Payment</th>
                                        <th>Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = $startrow;
                                    foreach ($customers as $customer) :
                                        $no++;
                                    ?>
                                        <tr>
                                            <td>
                                                <a class="btn btn-primary btn-sm" href="<?= base_url(); ?>/account_receivable/detail/<?= $customer->id; ?>/<?= $tanggal; ?>">
                                                    <i class="fas fa-search"></i>
                                                </a>
                                            </td>
                                            <td><?= $no; ?></td>
                                            <td><?= $customer->id; ?></td>
                                            <td><?= $customer->company_name; ?></td>
                                            <td align="right"><?= $_this->amountformat($detail_data[$customer->id]["saldo_awal"]); ?></td>
                                            <td align="right"><?= $_this->amountformat($detail_data[$customer->id]["penjualan"]); ?></td>
                                            <td align="right"><?= $_this->amountformat($detail_data[$customer->id]["pelunasan"]); ?></td>
                                            <td align="right"><?= $_this->amountformat($detail_data[$customer->id]["saldo_akhir"]); ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <div class="row">
                        <!-- accepted payments column -->
                        <!-- /.col -->
                        <div class="col-6"></div>
                        <div class="col-6">

                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th style="width:50%">TOTAL:</th>
                                            <td align="right"><b><?= $_this->amountformat($total); ?></b></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- this row will not appear when printing -->
                    <div class="row no-print">
                        <div class="col-12">
                            <a href="#" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                            <button onclick="ar_action()" type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i>
                                Action
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>