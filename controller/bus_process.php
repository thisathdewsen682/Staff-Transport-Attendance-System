<?php
session_start();
include( '../includes/db_connect.php' );
include( '../model/Bus.class.php' );
include( '../common/common_function.php' );

$emp_no =  '';
$emp_name =  '';
$isadmin =  '';

if ( !isset( $_SESSION[ 'emp_no' ] ) ) {

    header( 'Location: login.php' );
} else {
    $emp_no =  $_SESSION[ 'emp_no' ];
    $emp_name =  $_SESSION[ 'emp_name' ];
    $isadmin =  $_SESSION[ 'is_admin' ];
}

if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {

    $vehicleNo = $_POST[ 'vehicle_no' ];
    $routeNo = $_POST[ 'route_no' ];
    $routeName = $_POST[ 'route_name' ];
    $type = $_POST[ 'type' ];
    //echo $type;
    $routeDistance1 = $_POST[ 'route_distance1' ];
    $routeDistance2 = $_POST[ 'route_distance2' ];

    $errors = array();

    if ( empty( $routeNo ) ) {
        array_push( $errors, 'Route No Is Empty' );
    }
    if ( empty( $routeName ) ) {
        array_push( $errors, 'Route Name Is Empty' );
    }

    if ( !$errors ) {

        $obj = new Bus( $vehicleNo, $routeNo, $routeName, $type, $routeDistance1, $routeDistance2 );

        $result = $obj->insertNewRoute( $conn, $obj, $routeNo );
        if ( $result ) {
            echo 'Success';

        }
    } else {
        foreach ( $errors as $error ) {
            echo 'Please Fill ' . $error .'<br>';
        }
    }

}