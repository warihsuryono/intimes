<!DOCTYPE html>
<html>

<head>
    <title>INTIMES QRCODE READER</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    <style>
        button {
            margin: 10px 0px 10px 0px;
            padding: 10px;
        }
    </style>
    <center>
        <div id="qr-reader" style="width:250px"></div>
    </center>
</body>
<script src="<?= base_url(); ?>/dist/js/html5-qrcode.min.js"></script>
<script src="<?= base_url(); ?>/plugins/jquery/jquery.min.js"></script>
<script>
    function docReady(fn) {
        if (document.readyState === "complete" || document.readyState === "interactive") {
            setTimeout(fn, 1);
        } else {
            document.addEventListener("DOMContentLoaded", fn);
        }
    }

    docReady(function() {
        function onScanSuccess(qrCodeMessage) {
            try {
                opener.document.getElementById("<?= @$_GET["e"]; ?>").value = qrCodeMessage;
            } catch (e) {}
            try {
                opener.document.getElementById("filter_form").submit();
            } catch (e) {}
            try {
                opener.on_qr_success(qrCodeMessage);
            } catch (e) {}
            try {
                window.close();
                window.location = "<?= base_url(); ?>/Qr_reader/qrcode_menu/" + qrCodeMessage;
            } catch (e) {
                window.location = "<?= base_url(); ?>/Qr_reader/qrcode_menu/" + qrCodeMessage;
            }
        }
        var html5QrcodeScanner = new Html5QrcodeScanner("qr-reader", {
            fps: 10,
            qrbox: 250
        });
        html5QrcodeScanner.render(onScanSuccess);

        $("#qr-reader").children()[0].style.display = "none";
        $("#qr-reader__dashboard_section_csr").find('button').click();
        waitForStart();
    });

    function waitForStart() {
        setTimeout(function() {
            var btnStartScanning = $("#qr-reader__dashboard_section_csr").find('button');
            if (btnStartScanning.html() == "Start Scanning") {
                var cameraSelect = $("#qr-reader__dashboard_section_csr").find('select');
                var cameraOptions = cameraSelect.html().split("value=\"");
                if (cameraOptions.length == 2) {
                    btnStartScanning.click();
                }
                if (cameraOptions.length > 2) {
                    var camearaselected = "";
                    for (var xx = 1; xx < cameraOptions.length; xx++) {
                        if (cameraOptions[xx].indexOf("back") > 0 || cameraOptions[xx].indexOf("belakang") > 0) {
                            camearaselected = cameraOptions[xx].split("\"")[0];
                        }
                    }
                    cameraSelect.val(camearaselected);
                    btnStartScanning.click();
                }
            } else {
                waitForStart();
            }
        }, 10);
    }
</script>

</html>