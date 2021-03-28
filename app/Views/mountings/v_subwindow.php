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
                                    <th>QrCode</th>
                                    <th>Vulkanisir</th>
                                    <th>Size</th>
                                    <th>Brand</th>
                                    <th>Type</th>
                                    <th>Tread Depth</th>
                                    <th>Pattern</th>
                                    <th>Psi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 0;
                                foreach ($tires as $tire) :
                                    $no++;
                                ?>
                                    <tr>
                                        <td>
                                            <button class="btn btn-success btn-sm" onclick="subwindow_tire_selected('<?= @$_GET['idx']; ?>','<?= $tire->id; ?>','<?= $tire->name; ?>')">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </td>
                                        <td><?= $tire->id; ?></td>
                                        <td><?= $tire->qrcode; ?></td>
                                        <td><?= ($tire->is_retread == "1") ? "Yes" : "No"; ?></td>
                                        <td><?= $tire_detail[$tire->id]["tire_size"]->name; ?></td>
                                        <td><?= $tire_detail[$tire->id]["tire_brand"]->name; ?></td>
                                        <td><?= $tire_detail[$tire->id]["tire_type"]->name; ?></td>
                                        <td><?= $tire->tread_depth; ?></td>
                                        <td><?= $tire->pattern; ?></td>
                                        <td><?= $tire->psi; ?></td>
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