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
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function loadImg(input, before_after, ii) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('img_' + before_after + '[' + ii + ']').src = e.target.result;
                document.getElementById('img_' + before_after + '[' + ii + ']').height = 400;

                $("#btnSave").html('<img src="<?= base_url(); ?>/dist/img/loader.gif" />');
                $("#btnSave").prop('disabled', true);
                try {
                    navigator.geolocation.getCurrentPosition(
                        function showPosition(position) {
                            $.ajax({
                                type: 'PUT',
                                url: '<?= base_url(); ?>/maintenance/put_image/<?= date("ymdhis"); ?>_' + before_after + '_<?= @$maintenance_id; ?>_' + current_scope_group_id + '_' + ii + "/" + position.coords.latitude + ";" + position.coords.longitude,
                                data: e.target.result
                            }).done(function(result) {
                                if (result != "0") {
                                    document.getElementById('img_' + before_after + '[' + ii + ']').src = "<?= base_url(); ?>/dist/upload/maintenance_photo/" + result;
                                }
                                $("#btnSave").html('Save');
                                $("#btnSave").prop('disabled', false);
                            });
                        }
                    );
                } catch (e) {
                    $.ajax({
                        type: 'PUT',
                        url: '<?= base_url(); ?>/maintenance/put_image/<?= date("ymdhis"); ?>_' + before_after + '_<?= @$maintenance_id; ?>_' + current_scope_group_id + '_' + ii + "/0;0",
                        data: e.target.result
                    }).done(function(result) {
                        console.log(result);
                        $("#btnSave").html('Save');
                        $("#btnSave").prop('disabled', false);
                    });
                }
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