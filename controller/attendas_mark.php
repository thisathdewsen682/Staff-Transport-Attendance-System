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

if ( $_SERVER[ 'REQUEST_METHOD' ]  == 'POST' && $_POST[ 'action' ] == 'in' ) {
    // Sanitize and validate input
    //echo $_POST[ 'checked' ];
    //echo $_POST[ 'route_no' ];
    //echo $_POST[ 'turncount_in' ];
    //echo $_POST[ 'vehicle_no' ];
    //echo $_POST[ 'employee_count' ];
    //echo $_POST[ 'action' ];
    echo $_POST[ 'additionalValueIn' ];
    $obj = new Attendance( $_POST[ 'route_no' ],
    $_POST[ 'route_name' ],
    $_POST[ 'vehicle_no' ],
    $_POST[ 'driver' ],
    $_POST[ 'helper' ],
    $_POST[ 'employee_count' ],
    today(),
    markTime(),
    '',
    'arrived',
    currentTime(),
    '',
    $_POST[ 'turncount_in' ],
    $_POST[ 'distanceIn' ],
    '',
    $_POST[ 'additionalValueIn' ],
    '',
    '',
    '' );

    //var_dump( $obj );

    $result = $obj->markAttendace( $conn, $obj );

    if ( $result ) {
        echo $_POST[ 'route_name' ] . ' (' . $_POST[ 'route_no' ] . ') ' . $_POST[ 'vehicle_no' ] . ' Marked In Successfully';

    } else {
        echo mysqli_error( $conn );

    }

}

if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST'  && $_POST[ 'action' ] == 'out' ) {
    $rno = $_POST[ 'route_no' ];

    //echo 'sss';
    echo $_POST[ 'additionalValueOut' ];
    $obj = new Attendance( $rno,
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    markTime(),
    'arrived and departured',
    '',
    '',
    $_POST[ 'turncount_out' ],
    '',
    $_POST[ 'distanceOut' ],
    '',
    $_POST[ 'additionalValueOut' ],
    '',
    '' );

    $result = $obj->markOut( $conn, $obj, $rno );

    if ( $result ) {
        echo   $rno . ' Marked Out Successfully';

    } else {
        echo mysqli_error( $conn );

    }
}
// Sanitize and validate input
?>