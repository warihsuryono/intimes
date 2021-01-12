<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <form role="form" method="POST">
                        <div class="card-body">
                            <div class="row">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Size Name</label>
                                            <input name="name" value="<?= @$_GET["name"]; ?>" type="text" class="form-control" placeholder="Size Name ...">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Diameter</label>
                                            <input name="diameter" value="<?= @$_GET["diameter"]; ?>" type="number" step="0.1" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Width</label>
                                            <input name="width" value="<?= @$_GET["width"]; ?>" type="number" step="0.1" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Wheel</label>
                                            <input name="wheel" value="<?= @$_GET["wheel"]; ?>" type="number" step="0.1" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Sidewall</label>
                                            <input name="sidewall" value="<?= @$_GET["sidewall"]; ?>" type="number" step="0.1" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Circumference</label>
                                            <input name="circumference" value="<?= @$_GET["circumference"]; ?>" type="number" step="0.1" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Revolutions Per Mile</label>
                                            <input name="revs_mile" value="<?= @$_GET["revs_mile"]; ?>" type="number" step="0.1" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" card-footer">
                            <a href="<?= base_url(); ?>/tire_sizes" class="btn btn-info">Back</a>
                            <button type="submit" name="Save" value="save" class="btn btn-primary float-right">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>