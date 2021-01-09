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
                                    <th>Diserahakan oleh</th>
                                    <th>Diterima pada</th>
                                    <th>No Sampel</th>
                                    <th>Merk</th>
                                    <th>Tipe</th>
                                    <th>S/N</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 0;
                                foreach ($instrument_acceptances as $instrument_acceptance) :
                                    foreach ($instrument_acceptance_details[$instrument_acceptance->id] as $instrument_acceptance_detail) :
                                        $no++;
                                ?>
                                        <tr>
                                            <td>
                                                <button class="btn btn-success btn-sm" onclick="subwindow_instrument_acceptance_selected('<?= $instrument_acceptance->id; ?>','<?= $instrument_acceptance_detail->id; ?>','<?= $instrument_acceptance_detail->sample_no; ?>')">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                            </td>
                                            <td><?= $instrument_acceptance->customer_name; ?></td>
                                            <td><?= $instrument_acceptance->submitted_by; ?></td>
                                            <td><?= date("d-m-Y H:i:s", strtotime($instrument_acceptance->accepted_at)); ?></td>
                                            <td><?= $instrument_acceptance_detail->sample_no; ?></td>
                                            <td><?= $instrument_acceptance_detail->brand; ?></td>
                                            <td><?= $instrument_acceptance_detail->instrument_type; ?></td>
                                            <td><?= $instrument_acceptance_detail->serialnumber; ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>