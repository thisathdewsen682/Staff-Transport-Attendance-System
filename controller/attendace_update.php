<?php
session_start();
include( '../includes/db_connect.php' );
include( '../common/common_function.php' );
include( '../model/Attendance.class.php' );

$emp_no =  '';
$emp_name = '';
$isadmin = '';

if ( !empty( $_SERVER[ 'HTTP_CLIENT_IP' ] ) ) {
    //ip from share internet
    $ip = $_SERVER[ 'HTTP_CLIENT_IP' ];
} elseif ( !empty( $_SERVER[ 'HTTP_X_FORWARDED_FOR' ] ) ) {
    //ip pass from proxy
    $ip = $_SERVER[ 'HTTP_X_FORWARDED_FOR' ];
} else {
    $ip = $_SERVER[ 'REMOTE_ADDR' ];
}

if ( !isset( $_SESSION[ 'emp_no' ] ) ) {

    header( 'Location: login.php' );
} else {
    $emp_no =  $_SESSION[ 'emp_no' ];
    $emp_name =  $_SESSION[ 'emp_name' ];
    $isadmin =  $_SESSION[ 'is_admin' ];
}

if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
    if ( isset( $_POST[ 'recordID' ] ) ) {

        $id = $_POST[ 'recordID' ];
        $vehicleNo = $_POST[ 'vehicle_no' ];
        $staffCount = $_POST[ 'staff_count' ];
        $inTime = $_POST[ 'startTime' ];
        $outTime = $_POST[ 'endTime' ];
        $route_distance1 = $_POST[ 'route_distance1' ];
        $route_distance2 = $_POST[ 'route_distance2' ];
        $additional_in = $_POST[ 'additional_in' ];
        $aditional_out = $_POST[ 'aditional_out' ];
        $turn_count = $_POST[ 'turn_count' ];

        $driver = '0';
        $helper = '0';
        if ( isset( $_POST[ 'driver' ] ) ) {
            $driver  = $_POST[ 'driver' ];
            //echo $driver;
        }

        if ( isset( $_POST[ 'helper' ] ) ) {
            $helper  = $_POST[ 'helper' ];
            //echo $helper;
        }

        $att = new Attendance( '', '', $vehicleNo, $driver, $helper, $staffCount, '', $inTime, $outTime, 'changed', '', currentTime(), $turn_count, $route_distance1, $route_distance2, $additional_in, $aditional_out, $ip, $emp_no );

        $result = $att->updateAttendanceById( $conn, $att, $id );

        if ( $result ) {
            echo 'Data Upate Success';
        } else {
            echo 'Data Update Failed';
        }
    }
}
//update attendance by admin
if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
    if ( isset( $_POST[ 'attid' ] ) ) {

        $driver = '0';
        $helper = '0';
        if ( isset( $_POST[ 'driver' ] ) ) {
            $driver  = $_POST[ 'driver' ];
            //echo $driver;
        }
        if ( isset( $_POST[ 'helper' ] ) ) {
            $helper  = $_POST[ 'helper' ];
            //echo $helper;
        }
        $id = $_POST[ 'attid' ];
        // echo $id;
        $vehicle_no = $_POST[ 'vehicle_no' ];
        $staff_count = $_POST[ 'staff_count' ];
        $startTime = $_POST[ 'startTime' ];
        $endTime = $_POST[ 'endTime' ];
        $status = $_POST[ 'status' ];
        $additional_in = $_POST[ 'additional_in' ];
        $aditional_out = $_POST[ 'additional_out' ];
        //$turn_count = $_POST[ 'turn_count' ];
        $route_distance = $_POST[ 'route_distance' ];
        //$route_distance_div = ( parseFloat( $route_distance )/2 );
        $route_distance_div = floatval( $route_distance ) / 2;

        $att = new Attendance( '', '', $vehicle_no, $driver, $helper, $staff_count, '', $startTime, $endTime, 'changed', '', currentTime(), '', $route_distance_div, $route_distance_div, $additional_in, $aditional_out, $ip, $emp_no );

        $result = $att->updateAttendanceById( $conn, $att, $id );

        if ( $result ) {
            echo 'Data Upate Success';
        } else {
            echo 'Data Update Failed';
        }

    }
}