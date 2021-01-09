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
                                        <label for="invoice_no">Invoice No</label>
                                        <input type="text" class="form-control" value="<?= $generate_supplier_invoice_no; ?>" name="invoice_no" placeholder="Auto Generate" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="po_id">Supplier PO</label>
                                        <select name="po_id" class="form-control" onchange="load_po(this.value)">
                                            <option value="">-- Supplier PO --</option>
                                            <?php foreach ($po_ as $po) : ?>
                                                <option value="<?= $po->id; ?>"><?= $po->po_no; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="supplier_id">supplier</label>
                                        <select name="supplier_id" class="form-control">
                                            <option value="">-- supplier --</option>
                                            <?php foreach ($suppliers as $supplier) : ?>
                                                <option value="<?= $supplier->id; ?>"><?= $supplier->company_name; ?></option>
                                            <?php endforeach ?>
                                        </select>
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
                                        <label for="issued_at">Issued At</label>
                                        <input type="date" class="form-control" name="issued_at" placeholder="Issued At ...">
                                    </div>
                                </div>
                                <div class=" col-sm-4">
                                    <div class="form-group">
                                        <label for="payment_type_id ">Payment Type</label>
                                        <select name="payment_type_id" class="form-control">
                                            <option value="">-- Payment Type --</option>
                                            <?php foreach ($payment_types as $payment_type) : ?>
                                                <option value="<?= $payment_type->id; ?>"><?= $payment_type->name; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="due_date">Due Date (Days)</label>
                                        <input type="text" class="form-control" name="due_date" placeholder="Due Date ...">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" name="description" placeholder="Description ..."></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="is_tax">is Tax</label>
                                        <select name="is_tax" class="form-control" onchange="calculate()">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label>Sub Total</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="number" step="0.01" class="form-control text-right" name="subtotal" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label>Tax</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="number" step="0.01" class="form-control text-right" name="tax" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label>TOTAL</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="number" step="0.01" class="form-control text-right" name="total" readonly>
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
                                            <th>Item</th>
                                            <th>Unit</th>
                                            <th>Qty</th>
                                            <th>Price</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody id="supplier_invoice_details_body"></tbody>
                                </table>
                            </div>
                            <div class=" card-footer">
                                <a href="<?= base_url(); ?>/supplier_invoice" class="btn btn-info">Back</a>
                                <button type="submit" name="Save" value="save" class="btn btn-primary float-right">Save</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>