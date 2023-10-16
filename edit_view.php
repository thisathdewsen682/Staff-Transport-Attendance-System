<?php
session_start();
include( 'includes/db_connect.php' );
include( 'common/common_function.php' );
include( 'model/Attendance.class.php' );

if ( !isset( $_SESSION[ 'emp_no' ] ) ) {

    header( 'Location: login.php' );
}
$emp_no =  $_SESSION[ 'emp_no' ];
$emp_name =  $_SESSION[ 'emp_name' ];
$isadmin =  $_SESSION[ 'is_admin' ];

?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Transport Vehicle Attendace System</title>
    <link rel='icon' type='image/x-icon' href='img/icon.png'>

    <link rel='stylesheet' href='bootstrap/css/bootstrap.min.css'>
    <link rel='stylesheet' href='css/style1.css'>

</head>

<body>
    <?php require_once( 'includes/header.php' );
?>

    <?php

if ( isset( $_GET[ 'rid' ] ) ) {

    $report_id = $_GET[ 'rid' ];

    $report = new Attendance( '', '', '', '', '', '', '', '', '', '' );

    $result = $report->viewAttendanceByID1( $conn, $report_id, $report );

    while ( $row = mysqli_fetch_assoc( $result ) ) {

        echo "
        <div class='container mt-3'>
            <form>
                <div class='row'>
                    <div class='col-lg-6 col-md-6 col-sm-12 d-flex justify-content-center align-items-center'>
                        <label for='vehicleNo' class='form-label'>Vehicle No</label>
                        <input class='form-control form-control-lg' type='text' placeholder='Vehicle No'
                            aria-label='.form-control-lg example' value='" . $row[ 'vehicle_no' ] . "'>
                    </div>
                    <div class='col-lg-6 col-md-6 col-sm-12 d-flex justify-content-center align-items-center'>
                        <label for='staffCount' class='form-label'>Staff Count</label>
                        <input class='form-control form-control-lg' type='text' placeholder='Staff Count'
                            aria-label='.form-control-lg example' value='" . $row[ 'staff_count' ] . "'>
                    </div>
                    <div class='col-lg-6 col-md-6 col-sm-12 d-flex justify-content-center align-items-center mt-2'>
                        <label for='startTime' class='form-label'>Start Time</label>
                        <input type='time' name='startTime' id='startTime' class='form-control form-control-lg text-center'
                            value='" . $row[ 'mark_in' ] . "'>
                    </div>
                    <div class='col-lg-6 col-md-6 col-sm-12 d-flex justify-content-center align-items-center mt-2'>
                        <label for='endTime' class='form-label'>End Time</label>
                        <input type='time' name='endTime' id='endTime' class='form-control form-control-lg text-center'
                            value='" . $row[ 'mark_out' ] . "'>
                    </div>
                    <input type='hidden' name='recordID' value='" . $row[ 'attendance_id' ] . "'>
                    <div class='col-lg-12 col-md-12 col-sm-12 d-flex justify-content-center align-items-center mt-3'>
                          <input type = 'submit' value = 'submit' class = 'p-2'>
                    </div>
                 
                </div>
            </form>
        </div>";
    }

}

?>

    <script src='bootstrap/js/bootstrap.js'></script>
    <script src='js/time.js'></script>
</body>

</html>