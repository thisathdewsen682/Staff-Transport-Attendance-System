<?php
session_start();
include( 'includes/db_connect.php' );
include( 'common/common_function.php' );
include( 'model/Bus.class.php' );
include( 'model/Attendance.class.php' );

$emp_no =  '';
$emp_name =  '';
$isadmin =  '';

if ( isset( $_SESSION[ 'emp_no' ] ) ) {

    $emp_no =  $_SESSION[ 'emp_no' ];
    $emp_name =  $_SESSION[ 'emp_name' ];
    $isadmin =  $_SESSION[ 'is_admin' ];

    if ( !$isadmin == '1' ) {
        header( 'Location: ../index.php' );
        $_SESSION[ 'not_admin' ] = 'Your Not An Admin Please Log in Admin Account';
    }

} else {

    header( 'Location: ../login.php' );
}

if ( isset( $_GET[ 'isCheckSet' ] ) ) {

    $endDate = $_GET[ 'endDate' ];
    $startDate = $_GET[ 'startDate' ];
    $routeNO = $_GET[ 'routeNo' ];

    $records = Attendance::getCalculationReport( $conn, $startDate, $endDate, $routeNO );
    echo json_encode( $records );
}