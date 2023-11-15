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

if ( isset( $_GET[ 'id' ] ) ) {
    $id = $_GET[ 'id' ];

    $result = Bus::viewEditFormByID( $conn, $id );
    while( $row = mysqli_fetch_assoc( $result ) ) {
        $id = $row[ 'id' ];
        $vehicle_no = $row[ 'vehicle_no' ];
        $route_no = $row[ 'route_no' ];
        $route = $row[ 'route' ];
        $type = $row[ 'type' ];
        $route_distance1 = $row[ 'route_distance1' ];
        $route_distance2 = $row[ 'route_distance2' ];

        // Create an associative array with the values
        $data = array(
            'id' => $id,
            'vehicle_no' => $vehicle_no,
            'route_no' => $route_no,
            'route' => $route,
            'type' => $type,
            'route_distance1' => $route_distance1,
            'route_distance2' => $route_distance2
        );

        // Convert the array to JSON
        $json_data = json_encode( $data );

        // Return the JSON response
        echo $json_data;

    }

}

if ( isset( $_GET[ 'attid' ] ) ) {
    $id = $_GET[ 'attid' ];

    $result = Attendance::viewAttEditFormByID( $conn, $id );
    while( $row = mysqli_fetch_assoc( $result ) ) {
        $checked1 = '';
        $checked2 = '';

        if ( $row[ 'driver' ] == '1' ) {
            $checked1 = 'checked';
        }

        if ( $row[ 'helper' ] == '1' ) {
            $checked2 = 'checked';
        }
        $route_distance = $row[ 'full_route_distance_km' ];
        $route_distance_rounded = round( $route_distance, 2 );

        $id = $row[ 'attendance_id' ];
        $staff_count = $row[ 'staff_count' ];
        $vehicle_no = $row[ 'vehicle_no' ];
        $mark_in = $row[ 'mark_in' ];
        $mark_out = $row[ 'mark_out' ];
        $additional_in = $row[ 'additional_in' ];
        $aditional_out = $row[ 'aditional_out' ];

        $status = $row[ 'status' ];
        $route_distance = $row[ 'full_route_distance_km' ];
        $turn_count = $row[ 'turn_count' ];

        // Create an associative array with the values
        $data = array(
            'id' => $id,
            'staff_count' => $staff_count,
            'vehicle_no' => $vehicle_no,
            'mark_in' => $mark_in,
            'mark_out' => $mark_out,
            'status' => $status,
            'route_distance' => $route_distance_rounded,
            'additional_in' => $additional_in,
            'aditional_out' => $aditional_out,
            'turn_count' => $turn_count,
            'checked1' => $checked1,
            'checked2' => $checked2
        );

        // Convert the array to JSON
        $json_data = json_encode( $data );

        // Return the JSON response
        echo $json_data;

    }

}
?>