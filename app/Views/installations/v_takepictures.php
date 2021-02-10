<!-- Main content -->
<style>
    .pull-right {
        float: right !important;
        color: #3c8dbc !important;
    }
</style>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <form role="form" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">
                                <div class='col-sm-12'>
                                    <div class="form-group">
                                        <!-- <label>
                                            <h2><i class='fa fa-trash' onclick='remove_img(" + ii + ")'></i></h2>
                                        </label> -->
                                        <label>
                                            <h3>Tire Installation Pictures</h3>
                                        </label>
                                        <label for='takepicture_tire'>
                                            <h2><i class='fa fa-camera' aria-hidden='true'></i></h2>
                                        </label>
                                        <input onchange="loadImg(this,'tire');" type="file" capture="camera" name='takepicture_tire' id='takepicture_tire' style='display:none;'>
                                        <div id="tire_pictures">
                                            <?php foreach ($installation_pictures["tire"] as $installation_picture) : ?>
                                                <?= "<img style='margin:10px;' height='200' src='" . base_url() . "/dist/upload/installations/" . $installation_picture->filename . "'>"; ?>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class='col-sm-12'>
                                    <div class="form-group">
                                        <label>
                                            <h3>Flap Installation Pictures</h3>
                                        </label>
                                        <label for='takepicture_flap'>
                                            <h2><i class='fa fa-camera' aria-hidden='true'></i></h2>
                                        </label>
                                        <input onchange="loadImg(this,'flap');" type="file" capture="camera" name='takepicture_flap' id='takepicture_flap' style='display:none;'>
                                        <div id="flap_pictures">
                                            <?php foreach ($installation_pictures["flap"] as $installation_picture) : ?>
                                                <?= "<img style='margin:10px;' height='200' src='" . base_url() . "/dist/upload/installations/" . $installation_picture->filename . "'>"; ?>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class='col-sm-12'>
                                    <div class="form-group">
                                        <label>
                                            <h3>Tube Installation Pictures</h3>
                                        </label>
                                        <label for='takepicture_tube'>
                                            <h2><i class='fa fa-camera' aria-hidden='true'></i></h2>
                                        </label>
                                        <input onchange="loadImg(this,'tube');" type="file" capture="camera" name='takepicture_tube' id='takepicture_tube' style='display:none;'>
                                        <div id="tube_pictures">
                                            <?php foreach ($installation_pictures["tube"] as $installation_picture) : ?>
                                                <?= "<img style='margin:10px;' height='200' src='" . base_url() . "/dist/upload/installations/" . $installation_picture->filename . "'>"; ?>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function loadImg(input, mode) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $.ajax({
                    type: 'PUT',
                    url: '<?= base_url(); ?>/installation/put_image/<?= $id; ?>/' + mode,
                    data: e.target.result
                }).done(function(result) {
                    var pictures = JSON.parse(result);
                    imgs = "";
                    for (var ii = 0; ii < pictures.length; ii++) {
                        imgs = imgs + "<img style='margin:10px;' height='200' src='<?= base_url(); ?>/dist/upload/installations/" + pictures[ii].filename + "'>";
                    }
                    $("#" + mode + "_pictures").html(imgs);
                });
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function remove_img(ii) {
        if (confirm("Are you sure want to delete this photo?")) {
            filename = document.getElementById("img_before[" + ii + "]").src;
            console.log(filename);
            $("#btnSave").html('<img src="<?= base_url(); ?>/dist/img/loader.gif" />');
            $("#btnSave").prop('disabled', true);
            $.ajax({
                type: 'PUT',
                url: '<?= base_url(); ?>/maintenance/delete_image',
                data: filename
            }).done(function(result) {
                document.getElementById('img_' + document.getElementById("beforeafter").value + '[' + ii + ']').src = "";
                $("#btnSave").html('Save');
                $("#btnSave").prop('disabled', false);
            });
        }
    }
</script>