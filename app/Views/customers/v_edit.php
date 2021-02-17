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
                                        <label for="industry_category_id">Industry Category</label>
                                        <select name="industry_category_id" class="form-control">
                                            <?php foreach ($industry_categories as $industry_category) : ?>
                                                <option value="<?= $industry_category->id; ?>"><?= $industry_category->name; ?></option>
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
                                        <label for="pool">Pool</label>
                                        <input type="text" name="pool" class="form-control" placeholder="Pool">
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
                                        <input type="phone" name="pic_phone" class="form-control" placeholder="PIC Phone">
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
                                        <input type="text" name="zipcode" class="form-control" placeholder="Zip Code">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="phone" name="phone" class="form-control" placeholder="Phone">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="fax">FAX</label>
                                        <input type="phone" name="fax" class="form-control" placeholder="FAX">
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
                                        <input type="text" name="npwp" class="form-control" placeholder="NPWP">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="nppkp">NPPKP</label>
                                        <input type="text" name="nppkp" class="form-control" placeholder="NPPKP">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="tax_invoice_no">TAX Invoice No</label>
                                        <input name="tax_invoice_no" class="form-control" placeholder="TAX Invoice No">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="bank_id">Banks</label>
                                        <select name="bank_id" class="form-control">
                                            <option value="" selected>-- Select Bank --</option>
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
                                        <input type="text" name="reg_code" class="form-control" placeholder="Reg Code">
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
                                        <label for="customer_level_id">Customer Level</label>
                                        <select name="customer_level_id" class="form-control">
                                            <option value="" selected>-- Select Customer Level --</option>
                                            <?php foreach ($customer_levels as $c_level) : ?>
                                                <option value="<?= $c_level->id; ?>"><?= $c_level->name; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="customer_prospect_id">Prospect</label>
                                        <select name="customer_prospect_id" class="form-control">
                                            <option value="" selected>-- Select Prospect --</option>
                                            <?php foreach ($customer_prospects as $customer_prospect) : ?>
                                                <option value="<?= $customer_prospect->id; ?>"><?= $customer_prospect->name; ?></option>
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
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="reg_at">AM (email)</label>
                                        <input type="email" name="am_by" class="form-control" placeholder="AM" value="<?= @$am_by; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" card-footer">
                            <a href="<?= base_url(); ?>/customers" class="btn btn-info">Back</a>
                            <button type="submit" name="Save" value="save" class="btn btn-primary float-right">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>