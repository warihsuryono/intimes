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
                                        <label>Registration Plate</label>
                                        <input name="registration_plate" type="text" class="form-control" placeholder="Registration Plate ...">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Vehicle Brand</label>
                                        <select name="vehicle_brand_id" class="form-control">
                                            <option value="">-- Select Vehicle Brand --</option>
                                            <?php foreach ($vehicle_brands as $vehicle_brand) : ?>
                                                <option value="<?= $vehicle_brand->id; ?>"><?= $vehicle_brand->name; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Vehicle Type</label>
                                        <select name="vehicle_type_id" class="form-control">
                                            <option value="">-- Select Vehicle Type --</option>
                                            <?php foreach ($vehicle_types as $vehicle_type) : ?>
                                                <option value="<?= $vehicle_type->id; ?>"><?= $vehicle_type->name; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Model</label>
                                        <input name="model" type="text" class="form-control" placeholder="Model ...">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Modi No</label>
                                        <input name="modi_no" type="text" class="form-control" placeholder="Modi No ...">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" card-footer">
                            <a href="<?= base_url(); ?>/vehicles" class="btn btn-info">Back</a>
                            <button type="submit" name="Save" value="save" class="btn btn-primary float-right">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>