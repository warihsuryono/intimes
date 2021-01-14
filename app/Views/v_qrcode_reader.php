<!DOCTYPE html>
<html>

<head>
    <title>INTIMES QRCODE READER</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
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
                opener.document.getElementById("filter_form").submit();
            } catch (err) {
                alert(err.message);
            }
            window.close();
        }
        var html5QrcodeScanner = new Html5QrcodeScanner("qr-reader", {
            fps: 10,
            qrbox: 250
        });
        html5QrcodeScanner.render(onScanSuccess);

        $("#qr-reader").children()[0].style.display = "none";
        $("#qr-reader__dashboard_section_csr").find('button').click();
    });
</script>

</html>