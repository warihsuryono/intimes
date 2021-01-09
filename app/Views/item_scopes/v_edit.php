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
                                        <label for="coa">Item Type</label>
                                        <select name="item_type_id" class="form-control">
                                            <option value=""></option>
                                            <?php foreach ($item_types as $i_type) : ?>
                                                <option value="<?= $i_type->id; ?>"><?= $i_type->name; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="name">Scope</label>
                                        <input type="text" name="name" class="form-control" placeholder="Item Scope">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="unit_id">Unit</label>
                                        <select name="unit_id" class="form-control">
                                            <?php foreach ($units as $unit) : ?>
                                                <option value="<?= $unit->id; ?>"><?= $unit->name; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="name">Additional Price</label>
                                        <input type="text" name="add_price" class="form-control" placeholder="Additional Price">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="price_currency_id">Currency / %</label>
                                        <select name="price_currency_id" class="form-control">
                                            <option value="%">%</option>
                                            <?php foreach ($currencies as $currency) : ?>
                                                <option value="<?= $currency->id; ?>"><?= $currency->id; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" card-footer">
                            <a href="<?= base_url(); ?>/item_scopes" class="btn btn-info">Back</a>
                            <button type="submit" name="Save" value="save" class="btn btn-primary float-right">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>