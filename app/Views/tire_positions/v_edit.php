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
                                        <label>Position Name</label>
                                        <input name="name" value="<?= @$_GET["name"]; ?>" type="text" class="form-control" placeholder="Position Name ...">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Left/Right</label>
                                        <select class="form-control" name="left_right">
                                            <option value=""></option>
                                            <option value="left" <?= (@$_GET["left_right"] == "left") ? "selected" : ""; ?>>Left</option>
                                            <option value="right" <?= (@$_GET["left_right"] == "right") ? "selected" : ""; ?>>Right</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Front/Rear</label>
                                        <select class="form-control" name="front_rear">
                                            <option value=""></option>
                                            <option value="front" <?= (@$_GET["front_rear"] == "front") ? "selected" : ""; ?>>Front</option>
                                            <option value="rear" <?= (@$_GET["front_rear"] == "rear") ? "selected" : ""; ?>>Rear</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Inner/Outter</label>
                                        <select class="form-control" name="inner_outter">
                                            <option value=""></option>
                                            <option value="inner" <?= (@$_GET["inner_outter"] == "inner") ? "selected" : ""; ?>>Inner</option>
                                            <option value="outter" <?= (@$_GET["inner_outter"] == "outter") ? "selected" : ""; ?>>Outter</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" card-footer">
                            <a href="<?= base_url(); ?>/tire_positions" class="btn btn-info">Back</a>
                            <button type="submit" name="Save" value="save" class="btn btn-primary float-right">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>