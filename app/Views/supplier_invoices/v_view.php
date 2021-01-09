<!-- Main content -->
<div class="invoice p-3 mb-3">
    <!-- title row -->
    <div class="row">
        <div class="col-12">
            <h4>
                PT. Trusur Unggul Teknusa
                <small class="float-right">Issued At: <?= date("d F Y", strtotime($supplier_invoice->issued_at)); ?></small>
            </h4>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            From
            <address>
                <strong>Finance PT Trusur Unggul Teknusa</strong><br>
                Jl. lapangan Tembak Raya No.64 G<br>
                Cibubur,Jakarta 13720<br>
                Phone: +62 (21) 2962 7001 - 3<br>
                Email: finance@trusur.com
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            To
            <address>
                <strong><?= @$supplier->pic; ?></strong><br>
                <?= wordwrap(@$supplier->address, 40, "<br>"); ?><br>
                <?= @$supplier->city; ?><br>
                Phone: <?= @$supplier->phone; ?><br>
                Email: <?= @$supplier->email; ?>
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <b>Invoice #<?= $supplier_invoice->invoice_no; ?></b><br>
            <br>
            <b>Supplier PO Number:</b> <?= $supplier_invoice->po_no; ?><br>
            <b>Due Date:</b> <?= date("d F Y", strtotime($supplier_invoice->due_date_at)); ?><br>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
        <div class="col-12 table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Qty</th>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($supplier_invoice_details as $supplier_invoice_detail) : ?>
                        <tr>
                            <td><?= $supplier_invoice_detail->qty; ?> <?= $supplier_invoice_detail_details[$supplier_invoice_detail->id]["unit"]->name; ?></td>
                            <td><?= $supplier_invoice_detail_details[$supplier_invoice_detail->id]["item"]->name; ?></td>
                            <td align="right"><?= $_this->amountformat($supplier_invoice_detail->price); ?></td>
                            <td><?= $supplier_invoice_detail->notes; ?></td>
                            <td align="right"><?= $_this->amountformat($supplier_invoice_detail_details[$supplier_invoice_detail->id]["subtotal"]); ?></td>
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
        <div class="col-6">
            <p class="lead">Payment Methods:</p>
            <img src="../../dist/img/credit/visa.png" alt="Visa">
            <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
            <img src="../../dist/img/credit/american-express.png" alt="American Express">
            <img src="../../dist/img/credit/paypal2.png" alt="Paypal">

        </div>
        <!-- /.col -->
        <div class="col-6">

            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr>
                            <th style="width:50%">Subtotal:</th>
                            <td align="right"><?= $_this->amountformat($supplier_invoice->subtotal); ?></td>
                        </tr>
                        <tr>
                            <th>Tax</th>
                            <td align="right"><?= $_this->amountformat($supplier_invoice->tax); ?></td>
                        </tr>
                        <tr>
                            <th>Total:</th>
                            <td align="right"><b><?= $_this->amountformat($supplier_invoice->total); ?></b></td>
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
            <a href="<?= base_url(); ?>/supplier_invoice/" class="btn btn-default"><i class="fas fa-chevron-left"></i> Back</a>
            <a href="#" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
            <button onclick="payment_action()" type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i>
                Action
            </button>
        </div>
    </div>
</div>

<script>
    var invoice_statuses = "<select class='form-control' id='action_invoice_status_id'>";
    <?php foreach ($supplier_invoice_statuses as $supplier_invoice_status) : ?>
        invoice_statuses += "<option value='<?= $supplier_invoice_status->id; ?>' <?= ($supplier_invoice_status->id == $supplier_invoice->invoice_status_id) ? "selected" : ""; ?>><?= $supplier_invoice_status->name; ?></option>";
    <?php endforeach ?>
    invoice_statuses += "</select>";

    function post_payment_action() {
        window.location = "<?= base_url(); ?>/supplier_invoice/view/<?= $supplier_invoice->id; ?>?action_invoice_status_id=" + $("#action_invoice_status_id").val();
    }

    function payment_action() {
        $('#modal_title').html('Invoice Action');
        $('#modal_message').html(invoice_statuses);
        $('#modal_type').attr("class", 'modal-content bg-info');
        $('#modal_ok_link').attr("href", "#");
        $('#modal_ok_link').attr("onclick", "post_payment_action()");
        $('#modal-form').modal();
    }
</script>