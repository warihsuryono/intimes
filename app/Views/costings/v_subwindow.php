<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body table-responsive p-0">
                        <table class="table table-head-fixed text-nowrap table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Id</th>
                                    <th>Specification</th>
                                    <th>Category</th>
                                    <th>Sub Category</th>
                                    <th>Type</th>
                                    <th>Scopes</th>
                                    <th>Item Brand</th>
                                    <th>Name</th>
                                    <th>Unit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 0;
                                foreach ($items as $item) :
                                    $no++;
                                ?>
                                    <tr>
                                        <td>
                                            <button class="btn btn-success btn-sm" onclick="subwindow_item_selected('<?= @$_GET['idx']; ?>','<?= $item->id; ?>','<?= $item->name; ?>','<?= $item_detail[$item->id]["item_type_id"]; ?>','<?= str_replace("|", "", str_replace("||", ",", $item->item_scope_ids)); ?>','<?= @$item_detail[$item->id]["prices"]->price; ?>','<?= $item->unit_id; ?>')">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </td>
                                        <td><?= $item->id; ?></td>
                                        <td><?= $item_detail[$item->id]["item_specification_id"]; ?></td>
                                        <td><?= $item_detail[$item->id]["item_category_id"]; ?></td>
                                        <td><?= $item_detail[$item->id]["item_sub_category_id"]; ?></td>
                                        <td><?= $item_detail[$item->id]["item_type_id"]; ?></td>
                                        <td><?= $item_detail[$item->id]["item_scopes"]; ?></td>
                                        <td><?= $item_detail[$item->id]["item_brand_id"]; ?></td>
                                        <td><?= $item->name; ?></td>
                                        <td><?= $item_detail[$item->id]["unit_id"]; ?></td>
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