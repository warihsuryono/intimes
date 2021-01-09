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
                                                <label>Periode</label>
                                                <input type="month" name="call_at" class="form-control" value="<?= @$_GET["call_at"]; ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Sales</label>
                                                <select name="sales_user_id" class="form-control">
                                                    <option value="">-- Sales --</option>
                                                    <?php foreach ($sales_users as $sales_user) : ?>
                                                        <option value="<?= $sales_user->id; ?>" <?= (@$_GET["sales_user_id"] == $sales_user->id) ? "selected" : ""; ?>><?= $sales_user->name; ?></option>
                                                    <?php endforeach ?>
                                                </select>
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
                <?php if (@$_GET["call_at"] != "" && @$_GET["sales_user_id"] != "") : ?>
                    <div class="content">
                        <div class="row">
                            <div class="col-sm-12"><b>Sales : <?= @$sales_name; ?></b></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12"><b>Periode : <?= date("F Y", strtotime($_GET["call_at"] . "-01")); ?></b></div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body table-responsive p-0" style="height: 700px;">
                            <table class="table table-head-fixed text-nowrap table-striped">
                                <thead>
                                    <tr>
                                        <th>Activity</th>
                                        <th>Target/Day</th>
                                        <?php for ($day = 1; $day <= date("t", strtotime($_GET["call_at"] . "-01")); $day++) : ?>
                                            <th><?= $day; ?></th>
                                        <?php endfor ?>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><b>Meeting</b></td>
                                        <td>1</td>
                                        <?php for ($day = 1; $day <= date("t", strtotime($_GET["call_at"] . "-01")); $day++) : ?>
                                            <?php $date = substr($_GET["call_at"], 0, 7) . "-" . str_pad($day, 2, "0", STR_PAD_LEFT); ?>
                                            <td align="right"><?= (@$activities[$date]["meeting"] * 1); ?></td>
                                        <?php endfor ?>
                                        <td align="right"><?= (@$total["meeting"] * 1); ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Cold Call</b></td>
                                        <td>25</td>
                                        <?php for ($day = 1; $day <= date("t", strtotime($_GET["call_at"] . "-01")); $day++) : ?>
                                            <?php $date = substr($_GET["call_at"], 0, 7) . "-" . str_pad($day, 2, "0", STR_PAD_LEFT); ?>
                                            <td align="right"><?= (@$activities[$date]["cold_call"] * 1); ?></td>
                                        <?php endfor ?>
                                        <td align="right"><?= (@$total["cold_call"] * 1); ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Quality Call</b></td>
                                        <td>20</td>
                                        <?php for ($day = 1; $day <= date("t", strtotime($_GET["call_at"] . "-01")); $day++) : ?>
                                            <?php $date = substr($_GET["call_at"], 0, 7) . "-" . str_pad($day, 2, "0", STR_PAD_LEFT); ?>
                                            <td align="right"><?= (@$activities[$date]["quality_call"] * 1); ?></td>
                                        <?php endfor ?>
                                        <td align="right"><?= (@$total["quality_call"] * 1); ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Quotation</b></td>
                                        <td>10</td>
                                        <?php for ($day = 1; $day <= date("t", strtotime($_GET["call_at"] . "-01")); $day++) : ?>
                                            <?php $date = substr($_GET["call_at"], 0, 7) . "-" . str_pad($day, 2, "0", STR_PAD_LEFT); ?>
                                            <td align="right"><?= (@$activities[$date]["quotation"] * 1); ?></td>
                                        <?php endfor ?>
                                        <td align="right"><?= (@$total["quotation"] * 1); ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Deal</b></td>
                                        <td>3</td>
                                        <?php for ($day = 1; $day <= date("t", strtotime($_GET["call_at"] . "-01")); $day++) : ?>
                                            <?php $date = substr($_GET["call_at"], 0, 7) . "-" . str_pad($day, 2, "0", STR_PAD_LEFT); ?>
                                            <td align="right"><?= (@$activities[$date]["deal"] * 1); ?></td>
                                        <?php endfor ?>
                                        <td align="right"><?= (@$total["deal"] * 1); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>