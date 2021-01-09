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
                                                <label>Accepted at</label>
                                                <input name="accepted_at" value="<?= @$_GET["accepted_at"]; ?>" type="date" class="form-control" placeholder="Accepted At ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Customer Name</label>
                                                <input name="customer_name" value="<?= @$_GET["customer_name"]; ?>" type="text" class="form-control" placeholder="Customer Name ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Instrument Name</label>
                                                <input name="instrument_name" value="<?= @$_GET["instrument_name"]; ?>" type="text" class="form-control" placeholder="Instrument Name ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Created By</label>
                                                <input name="created_by" value="<?= @$_GET["created_by"]; ?>" type="text" class="form-control" placeholder="Created By ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Sudah Dikaji Ulang</label>
                                                <select name="is_request_reviewed" class="form-control">
                                                    <option value=""> -- View All -- </option>
                                                    <option value="1" <?= (@$_GET["is_request_reviewed"] == 1) ? "selected" : ""; ?>>Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Sudah dicek dan dikerjakan</label>
                                                <select name="is_instrument_processed" class="form-control">
                                                    <option value=""> -- View All -- </option>
                                                    <option value="1" <?= (@$_GET["is_instrument_processed"] == 1) ? "selected" : ""; ?>>Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>sudah ada laporan sementara</label>
                                                <select name="is_calibration_form" class="form-control">
                                                    <option value=""> -- View All -- </option>
                                                    <option value="1" <?= (@$_GET["is_calibration_form"] == 1) ? "selected" : ""; ?>>Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Sudah ada verifikasi hasil</label>
                                                <select name="is_calibration_verificated" class="form-control">
                                                    <option value=""> -- View All -- </option>
                                                    <option value="1" <?= (@$_GET["is_calibration_verificated"] == 1) ? "selected" : ""; ?>>Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Sudah dibuat sertifikasi</label>
                                                <select name="is_calibration_certificated" class="form-control">
                                                    <option value=""> -- View All -- </option>
                                                    <option value="1" <?= (@$_GET["is_calibration_certificated"] == 1) ? "selected" : ""; ?>>Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Sudah dikembalikan</label>
                                                <select name="is_instrument_released" class="form-control">
                                                    <option value=""> -- View All -- </option>
                                                    <option value="1" <?= (@$_GET["is_instrument_released"] == 1) ? "selected" : ""; ?>>Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Created By</label>
                                                <input name="created_by" value="<?= @$_GET["created_by"]; ?>" type="text" class="form-control" placeholder="Created By ...">
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
                <div class="row" style="margin-bottom:10px;">
                    <div class="col-2">
                        <button class="btn btn-primary" onclick="window.location='<?= base_url(); ?>/instrument_acceptance/add';"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
                <div class="card">
                    <!--PAGING -->
                    <?php if ($numrow > MAX_ROW) : ?>
                        <?php if (!isset($_GET["page"])) $_GET["page"] = 1; ?>
                        <div class="card-header">
                            <div class="card-tools">
                                <div class="dataTables_paginate paging_simple_numbers">
                                    <ul class="pagination">
                                        <li class="paginate_button page-item previous"><a onclick="$('#page').val('1');$('#filter_form').submit();" href="#" class="page-link">First</a></li>
                                        <?php for ($page = 1; $page <= $maxpage; $page++) : ?>
                                            <li class="paginate_button page-item <?= ($_GET["page"] == $page) ? "active" : "" ?>"><a onclick="$('#page').val('<?= $page; ?>');$('#filter_form').submit();" href="#" class="page-link"><?= $page; ?></a></li>
                                        <?php endfor ?>
                                        <li class="paginate_button page-item next"><a onclick="$('#page').val('<?= $maxpage; ?>');$('#filter_form').submit();" href="#" class="page-link">Last</a></li>
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
                                    <th>Customer</th>
                                    <th>Diserahkan Oleh</th>
                                    <th>Tenggat Waktu</th>
                                    <th>Instrumen</th>
                                    <th>Pekerjaan</th>
                                    <th>Diterima</th>
                                    <th>Dikaji</th>
                                    <th>Dicek</th>
                                    <th>Laporan Sementara</th>
                                    <th>Verifikasi Hasil</th>
                                    <th>Sertifikasi</th>
                                    <th>Dikembalikan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = $startrow;
                                foreach ($instrument_acceptances as $instrument_acceptance) :
                                    $no++;
                                ?>
                                    <tr>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="<?= base_url(); ?>/instrument_acceptance/view/<?= $instrument_acceptance->id; ?>">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a class="btn btn-info btn-sm" href="<?= base_url(); ?>/instrument_acceptance/edit/<?= $instrument_acceptance->id; ?>">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm" href="#" onclick="delete_confirmation(<?= $instrument_acceptance->id; ?>);">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                        <td><?= $no; ?></td>
                                        <td><?= $instrument_acceptance->customer_name; ?></td>
                                        <td><?= $instrument_acceptance->submitted_by; ?></td>
                                        <td><?= date("d-m-Y", strtotime($instrument_acceptance->deadlines)); ?></td>
                                        <td><?= $instrument_acceptance_detail[$instrument_acceptance->id]["instruments"]; ?></td>
                                        <td><?= $instrument_acceptance->action_etc; ?></td>
                                        <td><?= ($instrument_acceptance->accepted_at) ? date("d-m-Y H:i:s", strtotime($instrument_acceptance->accepted_at)) : ""; ?></td>
                                        <td><?= ($instrument_acceptance_detail[$instrument_acceptance->id]["is_request_reviewed"]) ? "<i class='btn btn-success'>Sudah</i>" : "<i class='btn btn-danger'>Belum</i>"; ?></td>
                                        <td><?= ($instrument_acceptance_detail[$instrument_acceptance->id]["is_instrument_processed"]) ? "<i class='btn btn-success'>Sudah</i>" : "<i class='btn btn-danger'>Belum</i>"; ?></td>
                                        <td><?= ($instrument_acceptance_detail[$instrument_acceptance->id]["is_calibration_form"]) ? "<i class='btn btn-success'>Sudah</i>" : "<i class='btn btn-danger'>Belum</i>"; ?></td>
                                        <td><?= ($instrument_acceptance_detail[$instrument_acceptance->id]["is_calibration_verificated"]) ? "<i class='btn btn-success'>Sudah</i>" : "<i class='btn btn-danger'>Belum</i>"; ?></td>
                                        <td><?= ($instrument_acceptance_detail[$instrument_acceptance->id]["is_calibration_certificated"]) ? "<i class='btn btn-success'>Sudah</i>" : "<i class='btn btn-danger'>Belum</i>"; ?></td>
                                        <td><?= ($instrument_acceptance_detail[$instrument_acceptance->id]["is_instrument_released"]) ? "<i class='btn btn-success'>Sudah</i>" : "<i class='btn btn-danger'>Belum</i>"; ?></td>
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
        $('#modal_title').html('Delete Penerimaan Alat');
        $('#modal_message').html('Are you sure want to delete this data?');
        $('#modal_type').attr("class", 'modal-content bg-danger');
        $('#modal_ok_link').attr("href", '<?= base_url(); ?>/instrument_acceptance/delete/' + id);
        $('#modal-form').modal();
    }
</script>