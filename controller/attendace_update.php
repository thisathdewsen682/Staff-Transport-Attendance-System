<?php
session_start();
include( '../includes/db_connect.php' );
include( '../common/common_function.php' );
include( '../model/Attendance.class.php' );

if ( !isset( $_SESSION[ 'emp_no' ] ) ) {

    header( 'Location: login.php' );
}
$emp_no =  $_SESSION[ 'emp_no' ];
$emp_name =  $_SESSION[ 'emp_name' ];
$isadmin =  $_SESSION[ 'is_admin' ];

if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {

    $id = $_POST[ 'recordID' ];
    $vehicleNo = $_POST[ 'vehicle_no' ];
    $staffCount = $_POST[ 'staff_count' ];
    $inTime = $_POST[ 'startTime' ];
    $outTime = $_POST[ 'endTime' ];

    $driver = '0';
    $helper = '0';
    if ( isset( $_POST[ 'driver' ] ) ) {
        $driver  = $_POST[ 'driver' ];
        echo $driver;
    }

    if ( isset( $_POST[ 'helper' ] ) ) {
        $helper  = $_POST[ 'helper' ];
        echo $helper;
    }

    $att = new Attendance( '', '', $vehicleNo, $driver, $helper, $staffCount, '', $inTime, $outTime, 'changed', '', currentTime() );

    $result = $att->updateAttendanceById( $conn, $att, $id );

    if ( $result ) {
        echo 'Data Upate Success';
    } else {
        echo 'Data Update Failed';
    }

}