<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <form role="form" method="POST">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Type Name</label>
                                        <input name="name" value="<?= @$_GET["name"]; ?>" type="text" class="form-control" placeholder="Type Name ...">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h4><b>Tire Positions</b></h4>
                                <?php foreach ($tire_positions as $tire_position) : ?>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input <?= (in_array($tire_position->id, $tire_position_ids)) ? "checked" : ""; ?> id="tire_position_id[<?= $tire_position->id; ?>]" name="tire_position_id[<?= $tire_position->id; ?>]" value="1" type="checkbox"> <?= $tire_position->name; ?> (<?= $tire_position->code; ?>)
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                        <div class=" card-footer">
                            <a href="<?= base_url(); ?>/vehicle_types" class="btn btn-info">Back</a>
                            <button type="submit" name="Save" value="save" class="btn btn-primary float-right">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>