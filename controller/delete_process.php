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

if ( isset( $_GET[ 'delid' ] ) ) {
    $id = $_GET[ 'delid' ];
    $rno = $_GET[ 'rno' ];
    //$att = new Attendance( '', '', '', '', '', '', '', '', '', '', '' );
    $result = Attendance::deletById( $conn, $id );

    //echo $url = 'Location : ../report.php?rno=' . $rno;

    if ( $result ) {
        //echo 's';
        $_SESSION[ 'successmsg' ] = 'Record Deleted Succesfully';
        header( 'Location: ../report.php?rno=' . $rno );

        //
    } else {
        //echo 'f';
        $_SESSION[ 'erromsg' ] = 'Record Not Deleted';
        header( $url );

    }
}

if ( isset( $_GET[ 'attdelid' ] ) ) {

    $id = $_GET[ 'attdelid' ];
    //echo $id;

    $result = Attendance::deletById( $conn, $id );

}

?>