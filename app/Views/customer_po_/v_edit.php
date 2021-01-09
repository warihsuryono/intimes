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
                                        <label for="po_no">PO Number</label>
                                        <input type="text" class="form-control" name="po_no" placeholder="PO Number ...">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="quotation_no">Quotation No</label>
                                        <input type="text" class="form-control" name="quotation_no" placeholder="Quotation No ...">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="customer_id">Customer</label>
                                        <select name="customer_id" class="form-control">
                                            <option value="">-- Customer --</option>
                                            <?php foreach ($customers as $customer) : ?>
                                                <option value="<?= $customer->id; ?>"><?= $customer->company_name; ?></option>
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
                                        <label for="is_tax">is Tax</label>
                                        <select name="is_tax" class="form-control" onchange="calculate()">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="po_received_at">PO Received at</label>
                                        <input type="date" class="form-control" name="po_received_at" placeholder="PO Received at ...">
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
                                        <label for="shipment_pic">Shipment PIC</label>
                                        <input type="text" class="form-control" name="shipment_pic" placeholder="Shipment PIC ...">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="shipment_phone">Shipment Phone</label>
                                        <input type="text" class="form-control" name="shipment_phone" placeholder="Shipment Phone ...">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="shipment_address">Shipment Address</label>
                                        <textarea class="form-control" name="shipment_address" placeholder="Shipment Address ..."></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="shipment_at">Shipment At</label>
                                        <input type="date" class="form-control" name="shipment_at" placeholder="Shipment At ...">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="dp">Down Payment</label>
                                        <input type="number" step="0.01" class="form-control text-right" name="dp" placeholder="Down Payment ...">
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
                                        <label for="disc">Disc (%)</label>
                                        <input type="number" step="0.01" class="form-control text-right" name="disc" placeholder="Disc (%) ..." onkeyup="calculate()">
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
                                            <label>Discount</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="number" step="0.01" class="form-control text-right" name="discount" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label>After Discount</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="number" step="0.01" class="form-control text-right" name="after_disc" readonly>
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
                                    <tbody id="customer_po_details_body"></tbody>
                                </table>
                            </div>
                            <div class=" card-footer">
                                <a href="/customer_po" class="btn btn-info">Back</a>
                                <button type="submit" name="Save" value="save" class="btn btn-primary float-right">Save</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>