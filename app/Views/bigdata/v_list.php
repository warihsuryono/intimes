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
                                                <label>Company Name</label>
                                                <input name="company_name" value="<?= @$_GET["company_name"]; ?>" type="text" class="form-control" placeholder="Company Name ...">
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
                    <div class="card-body table-responsive p-0" style="height: 700px;">
                        <table class="table table-head-fixed text-nowrap table-striped">
                            <thead>
                                <tr>
                                    <th rowspan="2">Company Name</th>
                                    <th rowspan="2">Pool</th>
                                    <th rowspan="2">Vehicle No</th>
                                    <th rowspan="2">Type</th>
                                    <th rowspan="2">Tire QRCode</th>
                                    <th rowspan="2">Item</th>
                                    <th rowspan="2">Size</th>
                                    <th rowspan="2">Brand</th>
                                    <th rowspan="2">Pattern</th>
                                    <th rowspan="2">Position</th>
                                    <th rowspan="2">KM Install</th>
                                    <th rowspan="2">Install Date</th>
                                    <th rowspan="2">OTD</th>
                                    <?php for ($ii = 0; $ii < 7; $ii++) : ?>
                                        <th colspan="3"><?= ($ii + 1) ?></th>
                                    <?php endfor ?>
                                    <th colspan="3">Terakhir</th>
                                    <th rowspan="2">Used Ages</th>
                                    <th rowspan="2">Warning</th>
                                    <th rowspan="2">Estimation Used Ages</th>
                                </tr>
                                <tr>
                                    <?php for ($ii = 0; $ii < 7; $ii++) : ?>
                                        <th>KM Check</th>
                                        <th>Check Date</th>
                                        <th>RTD</th>
                                    <?php endfor ?>
                                    <th>KM Check</th>
                                    <th>Check Date</th>
                                    <th>RTD</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($customers as $customer) : ?>
                                    <?php foreach ($vehicles[$customer->id] as $vehicle) : ?>
                                        <?php foreach ($installations[$customer->id][$vehicle->id] as $installation) : ?>
                                            <tr>
                                                <td><?= $customer->company_name; ?></td>
                                                <td><?= $customer->pool; ?></td>
                                                <td><?= $vehicle->registration_plate; ?></td>
                                                <td nowrap>
                                                    <?= $vehicle_details[$vehicle->id]["vehicle_brand"]->name; ?>
                                                    <?= $vehicle_details[$vehicle->id]["vehicle_type"]->name; ?>
                                                    <?= $vehicle->model; ?>
                                                </td>
                                                <td><?= $installation->tire_qr_code; ?></td>
                                                <td><?= $installation_details[$installation->id]["tire_type"]->name; ?></td>
                                                <td><?= $installation_details[$installation->id]["tire_size"]->name; ?></td>
                                                <td><?= $installation_details[$installation->id]["tire_brand"]->name; ?></td>
                                                <td><?= $installation_details[$installation->id]["tire_pattern"]->name; ?></td>
                                                <td><?= $installation_details[$installation->id]["tire_position"]->name; ?></td>
                                                <td><?= $_this->format_amount($installation->km_install); ?></td>
                                                <td><?= $_this->format_tanggal($installation->installed_at); ?></td>
                                                <td><?= $installation->original_tread_depth; ?></td>
                                                <?php for ($ii = 0; $ii < 7; $ii++) : ?>
                                                    <td><?= $_this->format_amount(@$checkings[$customer->id][$vehicle->id][$installation->id][$ii]->check_km); ?></td>
                                                    <td><?= $_this->format_tanggal(@$checkings[$customer->id][$vehicle->id][$installation->id][$ii]->check_at); ?></td>
                                                    <td><?= @$checkings[$customer->id][$vehicle->id][$installation->id][$ii]->remain_tread_depth; ?></td>
                                                <?php endfor ?>
                                                <td><?= $_this->format_amount(@$checking_details[$installation->id]["last_check_km"]); ?></td>
                                                <td><?= $_this->format_tanggal(@$checking_details[$installation->id]["last_check_at"]); ?></td>
                                                <td><?= @$checking_details[$installation->id]["last_remain_tread_depth"]; ?></td>
                                                <td><?= $_this->format_amount(@$checking_details[$installation->id]["used_ages"]); ?></td>
                                                <td>2 mm</td>
                                                <td><?= $_this->format_amount(@$checking_details[$installation->id]["estimation_used_ages"]); ?></td>
                                            </tr>
                                        <?php endforeach ?>
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