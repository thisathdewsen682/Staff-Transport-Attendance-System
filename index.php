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
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Transpor Vehicle Attendace System</title>

    <link rel='stylesheet' href='bootstrap/css/bootstrap.min.css'>
    <link rel='stylesheet' href='css/style1.css'>

</head>

<body>
    <?php require_once( 'includes/header.php' );
?>

    <div class='container mt-5'>
        <div class='row row  justify-content-center'>

            <?php
// Start PHP session if not already started

// Your database connection code here
// $conn = mysqli_connect( ... );

$sql = 'SELECT * FROM vehicle_detail';
$result = mysqli_query( $conn, $sql );

    while ( $row = mysqli_fetch_assoc( $result ) ) {
        $route_no = $row['route_no'];
        $markIn = '';
        $markOut = '';
        $sql1 = "SELECT `mark_in`,`mark_out` FROM `attendance_tbl` WHERE `route_no` = $route_no AND `created_at` = (SELECT MAX(`created_at`) FROM `attendance_tbl` WHERE `route_no` = $route_no) LIMIT 1";

        $result1 = mysqli_query( $conn, $sql1 );
        if($result1){

        while($row1 = mysqli_fetch_assoc($result1)){
            $markIn = $row1['mark_in'];
            $markOut = $row1['mark_out'];
        }


        }
        echo "<div class='col-sm-4 col-md-4 col-lg-4 bus-no'>
                    <h6 class='in'>Mark In:" . $markIn . "</h6>
                    <h6 class='out'>Mark Out:" . $markOut . "</h6>
                    <h6 class='out w-100 text-right text-center''><a href=''>Report</a>
</h6>

                    
                    <h3 class='text-center'>Route " . $row[ 'route_no' ] . "</h3>
                    <h4 class='text-center'>" . $row[ 'route' ] . "</h4>
                    <input type='text' name='vhno' placeholder='Vehicle No' class='text-center w-100''>
                    <input type='text' name='employee_count' placeholder='Employee Count' class='text-center mt-2 w-100'>

                    <input type='hidden' name='rno' placeholder='Vehicle No' class='text-center w-100' value='" . $row[ 'route_no' ] . "'>
                    <input type='hidden' name='rname' placeholder='Employee Count' class='text-center mt-2 w-100' value='" . $row[ 'route' ] . "'>
                    <div class='row mt-4'>
                        <div class='col-md-6 text-center d-flex justify-content-center'>
                            <a href='#' class='btn btn-danger mark-in' >Mark In</a>
                        </div>
                        <div class='col-md-6 text-center d-flex justify-content-center'>
                            <a href='' class='btn btn-success mark-out'>Mark Out</a>
                        </div>
                    </div>
                </div>";
}

?>
        </div>
    </div>

    <script src='bootstrap/js/bootstrap.js'></script>
    <script src='ajax/time.js'></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var markInButtons = document.querySelectorAll('.mark-in');

        markInButtons.forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                var routeNo = this.closest('.bus-no').querySelector('input[name="rno"]').value;
                var routeName = this.closest('.bus-no').querySelector('input[name="rname"]')
                    .value;
                var vehicleNo = this.closest('.bus-no').querySelector('input[name="vhno"]')
                    .value;
                var employeeCount = this.closest('.bus-no').querySelector(
                    'input[name="employee_count"]').value;

                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'controller/attendas_mark.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // Handle success (if any)
                            alert(xhr.responseText);
                            window.location.reload();
                            button.setAttribute('disabled', 'true');
                        } else {
                            // Handle error (if any)
                            console.error(xhr.responseText);
                        }
                    }
                };

                var data = 'route_no=' + encodeURIComponent(routeNo) +
                    '&route_name=' + encodeURIComponent(routeName) +
                    '&vehicle_no=' + encodeURIComponent(vehicleNo) +
                    '&employee_count=' + encodeURIComponent(employeeCount) +
                    '&action=' + 'in';

                xhr.send(data);
            });
        });
    });


    document.addEventListener('DOMContentLoaded', function() {
        var markOutButtons = document.querySelectorAll('.mark-out');

        markOutButtons.forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();

                var routeNo = this.closest('.bus-no').querySelector('input[name="rno"]').value;
                // Send AJAX request to update mark_out
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'controller/attendas_mark.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 400) {
                        // Handle the response if needed
                        alert(xhr.responseText);
                        window.location.reload();
                    } else {
                        // Handle errors if any
                        console.log(xhr.responseText);
                    }
                };
                xhr.onerror = function() {
                    // Handle errors if any
                };
                var data = 'route_no=' + encodeURIComponent(routeNo) +
                    '&action=' + 'out';

                xhr.send(data);
                //xhr.send('route_no=' + routeNo + '&action=' + 'out');
            });
        });
    });
    </script>

    </script>
</body>

</html>