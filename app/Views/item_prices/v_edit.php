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
                                        <label for="journal_at">Code</label><br>
                                        <?= $item->code; ?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="coa">Specification</label><br>
                                        <?= $item_specification; ?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="coa">Category</label><br>
                                        <?= $item_category; ?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="coa">Sub Category</label><br>
                                        <?= $item_sub_category; ?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="coa">Type</label><br>
                                        <?= $item_type; ?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="item_brand_id">Brand</label><br>
                                        <?= $item_brand; ?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="name">Name</label><br>
                                        <?= $item->name; ?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="unit_id">Unit</label><br>
                                        <?= $unit; ?>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="cogs">COGS</label>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <select name="cogs_currency_id" class="form-control">
                                                    <?php foreach ($currencies as $currency) : ?>
                                                        <option value="<?= $currency->id; ?>" <?= ($currency->id == @$item_price->cogs_currency_id) ? "selected" : ""; ?>><?= $currency->id; ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text" name="cogs" class="form-control" placeholder="COGS" value="<?= @$item_price->cogs; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="price">Price</label>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <select name="price_currency_id" class="form-control">
                                                    <?php foreach ($currencies as $currency) : ?>
                                                        <option value="<?= $currency->id; ?>" <?= ($currency->id == @$item_price->price_currency_id) ? "selected" : ""; ?>><?= $currency->id; ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text" name="price" class="form-control" placeholder="Price" value="<?= @$item_price->price; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4><b>Costings</b></h4>
                        <a class="btn btn-primary" id="add-row"><i class="fa fa-plus"></i></a>
                        <div class="card">
                            <div class="card-body table-responsive p-0" style="height: 800px;" id="item_costing_body">

                            </div>
                            <div class=" card-footer">
                                <a href="<?= base_url(); ?>/item_prices" class="btn btn-info">Back</a>
                                <input type="hidden" name="Save" value="save">
                                <input type="button" name="btnSave" value="save" class="btn btn-primary float-right" onclick="if(before_submit()){submit();}">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>