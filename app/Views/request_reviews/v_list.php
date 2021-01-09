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
                                                <label>Admin Approved at</label>
                                                <input name="adm_approved_at" value="<?= @$_GET["adm_approved_at"]; ?>" type="date" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Tech Approved at</label>
                                                <input name="tech_approved_at" value="<?= @$_GET["tech_approved_at"]; ?>" type="date" class="form-control">
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
                                                <label>No Sampel</label>
                                                <input name="sample_no" value="<?= @$_GET["sample_no"]; ?>" type="text" class="form-control" placeholder="No Sampel ...">
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
                        <button class="btn btn-primary" onclick="window.location='<?= base_url(); ?>/request_review/add';"><i class="fa fa-plus"></i></button>
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
                                    <th>No Sampel</th>
                                    <th>Merk</th>
                                    <th>Tipe</th>
                                    <th>S/N</th>
                                    <th>Kesimpulan</th>
                                    <th>Admin Approved</th>
                                    <th>Tech Approved</th>
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
                                foreach ($request_reviews as $request_review) :
                                    $no++;
                                ?>
                                    <tr>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="<?= base_url(); ?>/request_review/view/<?= $request_review->id; ?>">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a class="btn btn-info btn-sm" href="<?= base_url(); ?>/request_review/edit/<?= $request_review->id; ?>">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm" href="#" onclick="delete_confirmation(<?= $request_review->id; ?>);">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                        <td><?= $no; ?></td>
                                        <td><?= $request_review_detail[$request_review->id]["instrument_acceptance"]->customer_name; ?></td>
                                        <td><?= $request_review->sample_no; ?></td>
                                        <td><?= @$request_review_detail[$request_review->id]["instrument_acceptance_detail"]->brand; ?></td>
                                        <td><?= @$request_review_detail[$request_review->id]["instrument_acceptance_detail"]->instrument_type; ?></td>
                                        <td><?= @$request_review_detail[$request_review->id]["instrument_acceptance_detail"]->serialnumber; ?></td>
                                        <td>
                                            <?php if ($request_review->summary_id == 1) : ?> Instrumen diterima <?php endif ?>
                                            <?php if ($request_review->summary_id == 0) : ?> Instrumen ditolak <?php endif ?>
                                            <?php if ($request_review->summary_id == 2) : ?> Instrumen dikontrakkan ke <?= $request_review->summary; ?> <?php endif ?>
                                        </td>
                                        <td><?= ($request_review->adm_approved_by) ? "<i class='btn btn-success'>Sudah</i>" : "<i class='btn btn-danger'>Belum</i>"; ?></td>
                                        <td><?= ($request_review->tech_approved_by) ? "<i class='btn btn-success'>Sudah</i>" : "<i class='btn btn-danger'>Belum</i>"; ?></td>
                                        <td><?= ($request_review_detail[$request_review->id]["is_instrument_processed"]) ? "<i class='btn btn-success'>Sudah</i>" : "<i class='btn btn-danger'>Belum</i>"; ?></td>
                                        <td><?= ($request_review_detail[$request_review->id]["is_calibration_form"]) ? "<i class='btn btn-success'>Sudah</i>" : "<i class='btn btn-danger'>Belum</i>"; ?></td>
                                        <td><?= ($request_review_detail[$request_review->id]["is_calibration_verificated"]) ? "<i class='btn btn-success'>Sudah</i>" : "<i class='btn btn-danger'>Belum</i>"; ?></td>
                                        <td><?= ($request_review_detail[$request_review->id]["is_calibration_certificated"]) ? "<i class='btn btn-success'>Sudah</i>" : "<i class='btn btn-danger'>Belum</i>"; ?></td>
                                        <td><?= ($request_review_detail[$request_review->id]["is_instrument_released"]) ? "<i class='btn btn-success'>Sudah</i>" : "<i class='btn btn-danger'>Belum</i>"; ?></td>
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
        $('#modal_title').html('Delete Kaji ulang kontrak');
        $('#modal_message').html('Are you sure want to delete this data?');
        $('#modal_type').attr("class", 'modal-content bg-danger');
        $('#modal_ok_link').attr("href", '<?= base_url(); ?>/request_review/delete/' + id);
        $('#modal-form').modal();
    }
</script>