<?php
session_start();
include( 'includes/db_connect.php' );
include( 'common/common_function.php' );
include( 'model/Attendance.class.php' );

/*if ( !isset( $_SESSION[ 'emp_no' ] ) ) {

    header( 'Location: login.php' );
}
$emp_no =  $_SESSION[ 'emp_no' ];
$emp_name =  $_SESSION[ 'emp_name' ];
$isadmin =  $_SESSION[ 'is_admin' ];
*/
if ( isset( $_GET[ 'rno' ] ) ) {

    $rno =  $_GET[ 'rno' ];

    echo $rno;

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
    $_GET[ 'turnCountOut' ],
    '',
    $_GET[ 'distanceOut' ],
    '',
    $_GET[ 'additionalValueOut' ],
    '',
    '' );

    $result = $obj->markOut( $conn, $obj, $rno );

    if ( $result ) {
        //  echo 'success';

    } else {
        // echo 'failed';
        //echo mysqli_error( $conn );
    }

}