<?php
session_start();
error_reporting( E_PARSE|E_WARNING|E_ERROR );
include( '../includes/db_connect.php' );
include( '../model/User.class.php' );

if ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST' ) {
    $usr_name = $_POST[ 'usr_name' ];
    $usr_psw = $_POST[ 'usr_psw' ];

    if ( empty( $usr_name ) || empty( $usr_psw ) ) {
        echo 'uname and password empty';
    } else {

        $emp_class_data = User::getUserByUnameAndPwd( $conn, $usr_name, $usr_psw );
        //var_dump( $emp_class_data );
        if ( $usr_name == $emp_class_data->user_name && $usr_psw == $emp_class_data->password ) {

            $_SESSION[ 'emp_name' ] = $emp_class_data->user_name;
            $_SESSION[ 'emp_no' ] = $emp_class_data->emp_no;
            $_SESSION[ 'is_admin' ] = $emp_class_data->is_admin;

            //echo $_SESSION[ 'emp_name' ];
            //echo $_SESSION[ 'is_admin' ];

            header( 'location:../index.php' );
        } else {
            header( 'location:../login.php' );
        }

    }

}