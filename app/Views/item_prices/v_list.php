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
                                                <label>Code</label>
                                                <input name="code" value="<?= @$_GET["code"]; ?>" type="text" class="form-control" placeholder="Code ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Item Specification</label>
                                                <select name="item_specification_id" class="form-control">
                                                    <option value="">-- Select Item Specification --</option>
                                                    <?php foreach ($item_specifications as $i_specification) : ?>
                                                        <option value="<?= $i_specification->id; ?>" <?= (@$_GET["item_specification_id"] == $i_specification->id) ? "selected" : ""; ?>><?= $i_specification->name; ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Item Category</label>
                                                <select name="item_category_id" class="form-control">
                                                    <option value="">-- Select Item Category --</option>
                                                    <?php foreach ($item_categories as $i_category) : ?>
                                                        <option value="<?= $i_category->id; ?>" <?= (@$_GET["item_category_id"] == $i_category->id) ? "selected" : ""; ?>><?= $i_category->name; ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Item Sub Category</label>
                                                <select name="item_sub_category_id" class="form-control">
                                                    <option value="">-- Select Item Sub Category --</option>
                                                    <?php foreach ($item_sub_categories as $i_sub_category) : ?>
                                                        <option value="<?= $i_sub_category->id; ?>" <?= (@$_GET["item_sub_category_id"] == $i_sub_category->id) ? "selected" : ""; ?>><?= $i_sub_category->name; ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Item Type</label>
                                                <select name="item_type_id" class="form-control">
                                                    <option value="">-- Select Item Type --</option>
                                                    <?php foreach ($item_types as $i_type) : ?>
                                                        <option value="<?= $i_type->id; ?>" <?= (@$_GET["item_type_id"] == $i_type->id) ? "selected" : ""; ?>><?= $i_type->name; ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Item Brand</label>
                                                <select name="item_brand_id" class="form-control">
                                                    <option value="">-- Select Item Brand --</option>
                                                    <?php foreach ($item_brands as $i_brand) : ?>
                                                        <option value="<?= $i_brand->id; ?>" <?= (@$_GET["item_brand_id"] == $i_brand->id) ? "selected" : ""; ?>><?= $i_brand->name; ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Item Name</label>
                                                <input name="name" value="<?= @$_GET["name"]; ?>" type="text" class="form-control" placeholder="Item Name ...">
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
                <div class="card">
                    <!--PAGING -->
                    <?php if ($numrow > MAX_ROW) : ?>
                        <?php if (!isset($_GET["page"])) $_GET["page"] = 1; ?>
                        <div class="card-header">
                            <div class="card-tools">
                                <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                                    <ul class="pagination">
                                        <li class="paginate_button page-item previous" id="example2_previous"><a onclick="$('#page').val('1');$('#filter_form').submit();" href="#" aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link">First</a></li>
                                        <?php for ($page = 1; $page <= $maxpage; $page++) : ?>
                                            <li class="paginate_button page-item <?= ($_GET["page"] == $page) ? "active" : "" ?>"><a onclick="$('#page').val('<?= $page; ?>');$('#filter_form').submit();" href="#" aria-controls="example2" data-dt-idx="1" tabindex="0" class="page-link"><?= $page; ?></a></li>
                                        <?php endfor ?>
                                        <li class="paginate_button page-item next" id="example2_next"><a onclick="$('#page').val('<?= $maxpage; ?>');$('#filter_form').submit();" href="#" aria-controls="example2" data-dt-idx="7" tabindex="0" class="page-link">Last</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                    <!--END PAGING -->
                    <div class="card-body table-responsive p-0" style="height: 700px;">
                        <table class="table table-head-fixed text-nowrap table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>No</th>
                                    <th>Code</th>
                                    <th>Specification</th>
                                    <th>Category</th>
                                    <th>Type</th>
                                    <th>Brand</th>
                                    <th>Name</th>
                                    <th>Unit</th>
                                    <th colspan="2">COGS</th>
                                    <th colspan="2">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = $startrow;
                                foreach ($items as $item) :
                                    $no++;
                                ?>
                                    <tr>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="<?= base_url(); ?>/item_price/edit/<?= $item->id; ?>">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                        <td><?= $no; ?></td>
                                        <td><?= $item->code; ?></td>
                                        <td><?= $item_detail[$item->id]["item_specification"]; ?></td>
                                        <td><?= $item_detail[$item->id]["item_category"]; ?></td>
                                        <td><?= $item_detail[$item->id]["item_type"]; ?></td>
                                        <td><?= $item_detail[$item->id]["item_brand"]; ?></td>
                                        <td><?= $item->name; ?></td>
                                        <td><?= $item_detail[$item->id]["unit"]; ?></td>
                                        <td><?= @$item_detail[$item->id]["item_price"]->cogs_currency_id; ?></td>
                                        <td align="right"><?= $_this->amountformat(@$item_detail[$item->id]["item_price"]->cogs); ?></td>
                                        <td><?= @$item_detail[$item->id]["item_price"]->price_currency_id; ?></td>
                                        <td align="right"><?= $_this->amountformat(@$item_detail[$item->id]["item_price"]->price); ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function delete_confirmation(id) {
        $('#modal_title').html('Delete Item');
        $('#modal_message').html('Are you sure want to delete this data?');
        $('#modal_type').attr("class", 'modal-content bg-danger');
        $('#modal_ok_link').attr("href", '<?= base_url(); ?>/item/delete/' + id);
        $('#modal-form').modal();
    }
</script>