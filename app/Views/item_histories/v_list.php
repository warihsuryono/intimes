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
                                                <label>In/Out</label>
                                                <select name="in_out" class="form-control">
                                                    <option value="">-- In/Out --</option>
                                                    <option value="in" <?= (@$_GET["in_out"] == "in") ? "selected" : ""; ?>>In</option>
                                                    <option value="out" <?= (@$_GET["in_out"] == "out") ? "selected" : ""; ?>>Out</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>History Type</label>
                                                <select name="item_history_type_id" class="form-control">
                                                    <option value="">-- History Type --</option>
                                                    <?php foreach ($item_history_types as $item_history_type) : ?>
                                                        <option value="<?= $item_history_type->id; ?>" <?= (@$_GET["item_history_type_id"] == $item_history_type->id) ? "selected" : ""; ?>><?= $item_history_type->name; ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Dok No</label>
                                                <input name="dok_no" value="<?= @$_GET["dok_no"]; ?>" type="text" class="form-control" placeholder="Dok No/Receive No/Po No ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Item Code</label>
                                                <input name="code" value="<?= @$_GET["code"]; ?>" type="text" class="form-control" placeholder="Item Code ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Notes</label>
                                                <input name="notes" value="<?= @$_GET["notes"]; ?>" type="text" class="form-control" placeholder="Notes ...">
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
                                    <th>No</th>
                                    <th>Date</th>
                                    <th>In/Out</th>
                                    <th>Type</th>
                                    <th>Dok No</th>
                                    <th>Item Code</th>
                                    <th>Item Name</th>
                                    <th>SKU</th>
                                    <th>Qty</th>
                                    <th>Unit</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = $startrow;
                                foreach ($item_histories as $item_history) :
                                    $no++;
                                ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= date("d-m-Y H:i:s", strtotime($item_history->created_at)); ?></td>
                                        <td><?= ucfirst($item_history->in_out); ?></td>
                                        <td><?= $item_history_detail[$item_history->id]["item_history_type"]; ?></td>
                                        <td><?= $item_history->dok_no; ?></td>
                                        <td><?= $item_history_detail[$item_history->id]["item"]->code; ?></td>
                                        <td><?= $item_history_detail[$item_history->id]["item"]->name; ?></td>
                                        <td><?= $item_history->sku; ?></td>
                                        <td align="right"><?= $item_history->qty; ?></td>
                                        <td><?= $item_history_detail[$item_history->id]["unit"]; ?></td>
                                        <td><?= $item_history->notes; ?></td>
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