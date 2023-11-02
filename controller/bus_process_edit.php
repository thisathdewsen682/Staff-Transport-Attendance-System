<?php

session_start();
include( '../includes/db_connect.php' );
include( '../model/Bus.class.php' );
include( '../common/common_function.php' );

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

if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
    if ( isset( $_POST[ 'id' ] ) ) {

        $id = $_POST[ 'id' ];
        $vehicle_no = $_POST[ 'vehicle_no' ];
        $route_no = $_POST[ 'route_no' ];
        $route = $_POST[ 'route' ];
        $type = $_POST[ 'type' ];
        $route_distance1 = $_POST[ 'route_distance1' ];
        $route_distance2 = $_POST[ 'route_distance2' ];

        //echo $route_distance2;

        $obj = new Bus( $vehicle_no, $route_no, $route, $type, $route_distance1, $route_distance2 );
        //var_dump( $obj );

        $result = $obj->updateBusById( $conn, $id, $obj );
    }
}