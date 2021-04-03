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
                                        <label for='takephoto'>
                                            <h1><i class='fa fa-camera' aria-hidden='true'></i></h1>
                                        </label>
                                        <input onchange="loadPhoto(this);" type="file" capture="camera" name='takephoto' id='takephoto' style='display:none;'>
                                        <div id="photos">
                                            <?php foreach ($mounting_photos as $mounting_photo) : ?>
                                                <?= "<img style='margin:10px;' height='200' src='" . base_url() . "/dist/upload/mountings/" . $mounting_photo->filename . "'>"; ?>
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
    function loadPhoto(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $.ajax({
                    type: 'PUT',
                    url: '<?= base_url(); ?>/mounting/put_photo/<?= $id; ?>',
                    data: e.target.result
                }).done(function(result) {
                    var photos = JSON.parse(result);
                    imgs = "";
                    for (var ii = 0; ii < photos.length; ii++) {
                        imgs = imgs + "<img style='margin:10px;' height='200' src='<?= base_url(); ?>/dist/upload/mountings/" + photos[ii].filename + "'>";
                    }
                    $("#photos").html(imgs);
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
                url: '<?= base_url(); ?>/mounting/delete_photo',
                data: filename
            }).done(function(result) {
                document.getElementById('img_' + document.getElementById("beforeafter").value + '[' + ii + ']').src = "";
                $("#btnSave").html('Save');
                $("#btnSave").prop('disabled', false);
            });
        }
    }
</script>