<?php
session_start();
include( 'includes/db_connect.php' );
include( 'common/common_function.php' );

if ( !isset( $_SESSION[ 'emp_no' ] ) ) {

    header( 'Location: login.php' );
}
$emp_no =  $_SESSION[ 'emp_no' ];
$emp_name =  $_SESSION[ 'emp_name' ];
$isadmin =  $_SESSION[ 'is_admin' ];

?>

<!DOCTYPE html>
<html lang = 'en'>

<head>
<meta charset = 'UTF-8'>
<meta name = 'viewport' content = 'width=device-width, initial-scale=1.0'>
<title>Transpor Vehicle Attendace System</title>

<link rel = 'stylesheet' href = 'bootstrap/css/bootstrap.min.css'>
<link rel = 'stylesheet' href = 'css/style1.css'>

</head>

<body>
<?php require_once( 'includes/header.php' );
?>