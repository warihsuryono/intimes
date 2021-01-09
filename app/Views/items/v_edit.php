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
                                        <label for="code">Code</label>
                                        <input type="text" name="code" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="item_specification_id">Specification</label>
                                        <select name="item_specification_id" class="form-control">
                                            <option value=""></option>
                                            <?php foreach ($item_specifications as $i_specifications) : ?>
                                                <option value="<?= $i_specifications->id; ?>"><?= $i_specifications->name; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="item_category_id">Category</label>
                                        <select name="item_category_id" class="form-control">
                                            <option value=""></option>
                                            <?php foreach ($item_categories as $i_category) : ?>
                                                <option value="<?= $i_category->id; ?>"><?= $i_category->name; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="item_sub_category_id">Sub Category</label>
                                        <select name="item_sub_category_id" class="form-control">
                                            <option value=""></option>
                                            <?php foreach ($item_sub_categories as $i_sub_category) : ?>
                                                <option value="<?= $i_sub_category->id; ?>"><?= $i_sub_category->name; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="item_type_id">Type</label>
                                        <select name="item_type_id" class="form-control" onchange="load_scopes(this.value)">
                                            <option value=""></option>
                                            <?php foreach ($item_types as $i_type) : ?>
                                                <option value="<?= $i_type->id; ?>"><?= $i_type->name; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="item_scope_ids[]">Scope/Range</label><br>
                                        <select name="item_scope_ids[]" class="form-control" multiple="multiple">
                                            <?php foreach ($item_scopes as $i_scope) : ?>
                                                <option value="<?= $i_scope->id; ?>"><?= $i_scope->name; ?> <?= @$_units[$i_scope->unit_id]; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="item_brand_id">Brand</label>
                                        <select name="item_brand_id" class="form-control">
                                            <option value=""></option>
                                            <?php foreach ($item_brands as $i_brand) : ?>
                                                <option value="<?= $i_brand->id; ?>"><?= $i_brand->name; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" class="form-control" placeholder="Item Name">
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
                                        <label for="stock_min">Min Stock</label>
                                        <input type="text" name="stock_min" class="form-control" placeholder="Min Stok">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="stock_max">Max Stock</label>
                                        <input type="text" name="stock_max" class="form-control" placeholder="Max Stock">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" card-footer">
                            <a href="<?= base_url(); ?>/items" class="btn btn-info">Back</a>
                            <button type="submit" name="Save" value="save" class="btn btn-primary float-right">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>