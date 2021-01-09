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
                                        <label for="supplier_group_id">Supplier Group</label>
                                        <select name="supplier_group_id" class="form-control">
                                            <?php foreach ($supplier_groups as $s_group) : ?>
                                                <option value="<?= $s_group->id; ?>"><?= $s_group->name; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="company_name">Company Name</label>
                                        <input type="text" name="company_name" class="form-control" placeholder="Company Name">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="pic">PIC</label>
                                        <input type="text" name="pic" class="form-control" placeholder="PIC">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="pic_phone">PIC Phone</label>
                                        <input type="number" name="pic_phone" class="form-control" placeholder="PIC Phone">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" class="form-control" placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <textarea class="form-control" name="address" placeholder="Address"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <input type="text" name="city" class="form-control" placeholder="City">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="province">Province</label>
                                        <input type="text" name="province" class="form-control" placeholder="Province">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <input type="text" name="country" class="form-control" placeholder="Country">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="zipcode">Zip Code</label>
                                        <input type="number" name="zipcode" class="form-control" placeholder="Zip Code">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="number" name="phone" class="form-control" placeholder="Phone">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="fax">FAX</label>
                                        <input type="number" name="fax" class="form-control" placeholder="FAX">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="nationality">Nationality</label>
                                        <input type="text" name="nationality" class="form-control" placeholder="Nationality">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="remarks">Remaks</label>
                                        <input type="text" name="remarks" class="form-control" placeholder="Remaks">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="npwp">NPWP</label>
                                        <input type="number" name="npwp" class="form-control" placeholder="NPWP">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="nppkp">NPPKP</label>
                                        <input type="number" name="nppkp" class="form-control" placeholder="NPPKP">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="tax_invoice_no">TAX Inoice No</label>
                                        <select name="tax_invoice_no" class="form-control">
                                            <?php foreach ($invoices as $invoice) : ?>
                                                <option value="<?= $invoice->invoice_no; ?>"><?= $invoice->invoice_no; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="coa">COA</label>
                                        <select name="coa" class="form-control">
                                            <?php foreach ($coas as $coa) : ?>
                                                <option value="<?= $coa->coa; ?>"><?= $coa->coa.' - '.$coa->description ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="payment_type_id">Supplier Group</label>
                                        <select name="payment_type_id" class="form-control">
                                            <?php foreach ($payment_types as $p_type) : ?>
                                                <option value="<?= $p_type->id; ?>"><?= $p_type->name; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="bank_id">Banks</label>
                                        <select name="bank_id" class="form-control">
                                            <?php foreach ($banks as $bank) : ?>
                                                <option value="<?= $bank->id; ?>"><?= $bank->name; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="bank_account">Bank Account</label>
                                        <input type="text" name="bank_account" class="form-control" placeholder="Bank Account">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="reg_code">Reg Code</label>
                                        <input type="number" name="reg_code" class="form-control" placeholder="Reg Code">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="reg_at">Reg At</label>
                                        <input type="date" name="reg_at" class="form-control" placeholder="Reg At">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="join_at">Join At</label>
                                        <input type="date" name="join_at" class="form-control" placeholder="Join At">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" name="description" placeholder="Description"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" card-footer">
                            <a href="<?= base_url(); ?>/suppliers" class="btn btn-info">Back</a>
                            <button type="submit" name="Save" value="save" class="btn btn-primary float-right">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>