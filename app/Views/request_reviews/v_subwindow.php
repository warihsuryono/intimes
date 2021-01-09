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
                                    <th>Company Name</th>
                                    <th>No Sampel</th>
                                    <th>Merk</th>
                                    <th>Tipe</th>
                                    <th>S/N</th>
                                    <th>Kesimpulan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 0;
                                foreach ($request_reviews as $request_review) :
                                    $no++;
                                ?>
                                    <tr>
                                        <td>
                                            <button class="btn btn-success btn-sm" onclick="subwindow_request_review_selected('<?= $request_review->id; ?>','<?= $request_review->instrument_acceptance_id; ?>','<?= $request_review->instrument_acceptance_detail_id; ?>','<?= $request_review->sample_no; ?>')">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </td>
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