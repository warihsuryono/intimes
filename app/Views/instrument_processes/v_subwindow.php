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
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 0;
                                foreach ($instrument_processes as $instrument_process) :
                                    $no++;
                                ?>
                                    <tr>
                                        <td>
                                            <button class="btn btn-success btn-sm" onclick="subwindow_instrument_process_selected('<?= $instrument_process->id; ?>','<?= $instrument_process->instrument_acceptance_id; ?>','<?= $instrument_process->sample_no; ?>')">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </td>
                                        <td><?= $instrument_process_detail[$instrument_process->id]["instrument_acceptance"]->customer_name; ?></td>
                                        <td><?= $instrument_process->sample_no; ?></td>
                                        <td><?= @$instrument_process_detail[$instrument_process->id]["instrument_acceptance_detail"]->brand; ?></td>
                                        <td><?= @$instrument_process_detail[$instrument_process->id]["instrument_acceptance_detail"]->instrument_type; ?></td>
                                        <td><?= @$instrument_process_detail[$instrument_process->id]["instrument_acceptance_detail"]->serialnumber; ?></td>
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