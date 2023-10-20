<?php

include 'phpqrcode/qrlib.php';
if ( isset( $_GET[ 'rno' ] ) )
$route_no = $_GET[ 'rno' ];
$qr_code_data = $route_no;

// Generate QR Code
QRcode::png( $qr_code_data, 'qrcodes/qrcode_' . $route_no . '.png', QR_ECLEVEL_L, 5 );

?>
<div class='qr'>
    <img src="qrcodes/qrcode_<?php echo $route_no; ?>.png" alt="QR Code for Route <?php echo $route_no; ?>">
</div>
<button class='print' onclick="printDiv('qr')">Print</button>
<input type="text">
<script>
function printDiv(divId) {
    var printContents = document.getElementById(divId).innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;
    Route No:

        window.print();

    document.body.innerHTML = originalContents;
}
</script>