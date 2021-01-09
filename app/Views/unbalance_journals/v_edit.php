<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <form role="form" method="POST">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="journal_at">Journal At</label>
                                        <input type="date" class="form-control" name="journal_at">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="invoice_no">Invoice No</label>
                                        <input type="text" class="form-control" name="invoice_no" placeholder="Invoice No">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="currency_id">Currency</label>
                                        <select name="currency_id" class="form-control">
                                            <?php foreach ($currencies as $currency) : ?>
                                                <option value="<?= $currency->id; ?>"><?= $currency->id; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" name="description" placeholder="Description"></textarea>
                                    </div>
                                </div>
                                <div class=" col-sm-4">
                                    <div class="form-group">
                                        <label for="bank_id ">Bank</label>
                                        <select name="bank_id" class="form-control">
                                            <?php foreach ($banks as $bank) : ?>
                                                <option value="<?= $bank->id; ?>"><?= $bank->name; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label>Total Debit</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="number" step="0.01" class="form-control text-right" name="total_debit" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label>Total Credit</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="number" step="0.01" class="form-control text-right" name="total_credit" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label>Balance</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="number" step="0.01" class="form-control text-right" name="balance" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body table-responsive p-0" style="height: 400px;">
                                <table class="table table-head-fixed text-nowrap table-striped">
                                    <thead>
                                        <tr>
                                            <th><a class="btn btn-primary" id="add-row"><i class="fa fa-plus"></i></a></th>
                                            <th>COA</th>
                                            <th>Description</th>
                                            <th>Debit</th>
                                            <th>Credit</th>
                                        </tr>
                                    </thead>
                                    <tbody id="journal_details_body"></tbody>
                                </table>
                            </div>
                            <div class=" card-footer">
                                <a href="<?= base_url(); ?>/journals" class="btn btn-info">Back</a>
                                <button type="submit" name="Save" value="save" class="btn btn-primary float-right">Save</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>