<?php
session_start();
include( 'includes/db_connect.php' );
include( 'common/common_function.php' );
include( 'model/Attendance.class.php' );

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
    <title>Transport Vehicle Attendace System</title>
    <link rel='icon' type='image/x-icon' href='img/icon.png'>

    <link rel='stylesheet' href='bootstrap/css/bootstrap.min.css'>
    <link rel='stylesheet' href='css/style1.css'>

    <script>
    // Function to prompt for password and set session variable if correct
    function promptForPassword() {
        var enteredPassword = prompt("Please enter the password:");


        var correctPassword = "111";

        if (enteredPassword === correctPassword) {

            <?php $_SESSION['authenticated'] = true; ?>;
        } else {
            alert("Incorrect password. Access denied.");
            window.location.href = 'index.php'; // Redirect to login page if incorrect
        }
    }

    promptForPassword();
    </script>

</head>

<body>
    <?php require_once( 'includes/header.php' );
?>
    <div class='container'>
        <div class='row'>
            <div class='col-md-3'>
                <button type='button' class='btn btn-primary btn-sm '>
                    <a href='index.php' class='home'>HOME</a>
                </button>
            </div>
        </div>
    </div>
    <?php

if ( isset( $_GET[ 'rid' ] ) ) {

    $report_id = $_GET[ 'rid' ];

    $report = new Attendance( '', '', '', '', '', '', '','', '',  '', '', '' );

    $result = $report->viewAttendanceByID1( $conn, $report_id, $report );

    while ( $row = mysqli_fetch_assoc( $result ) ) {

        $checked1 = '';
        $checked2 = '';

        if($row['driver'] == '1'){
            $checked1 = 'checked';
        }

        if($row['helper'] == '1'){
             $checked2 = 'checked';
        }

        echo "
        <div class='container mt-3'>
            <form  method = 'POST' id = 'attendanceUpdate'>
                <div class='row'>
                    <div class='col-lg-6 col-md-6 col-sm-12 d-flex justify-content-center align-items-center'>
                        <label for='vehicleNo' class='form-label'>Vehicle No</label>
                        <input name = 'vehicle_no' class='form-control form-control-lg' type='text'placeholder='Vehicle No'
                            aria-label='.form-control-lg example'  value='" . $row[ 'vehicle_no' ] . "'>
                    </div>
                    <div class='col-lg-6 col-md-6 col-sm-12 d-flex justify-content-center align-items-center'>
                        <label for='staffCount' class='form-label'>Staff Count</label>
                        <input class='form-control form-control-lg' name = 'staff_count' type='text' placeholder='Staff Count'
                            aria-label='.form-control-lg example' value='" . $row[ 'staff_count' ] . "'>
                    </div>
                    <div class='col-lg-6 col-md-6 col-sm-12 d-flex justify-content-center align-items-center mt-2'>
                        <label for='startTime' class='form-label'>Start Time</label>
                        <input type='time' name='startTime' id='startTime' class='form-control form-control-lg text-center'
                            value='" . $row[ 'mark_in' ] . "'>
                    </div>
                      
                    <div class='col-lg-6 col-md-6 col-sm-12 d-flex justify-content-center align-items-center mt-2'>
                        <label for='endTime' class='form-label'>End Time</label>
                        <input type='time' name='endTime' id='endTime' class='form-control form-control-lg text-center'
                            value='" . $row[ 'mark_out' ] . "'>
                    </div>

                    <div class='d-flex justify-content-center align-items-center mt-2'>
                        <div class='checkbox-group'>
                            <label>
                                <input type='checkbox' name='driver' value = '1' $checked1> Driver
                            </label>
                            <label>
                                <input type='checkbox' name='helper' value = '1' $checked2> Helper
                            </label>
                        </div>
                    </div>
                    <input type='hidden' name='recordID' value='" . $row[ 'attendance_id' ] . "'>
                    <div class='col-lg-12 col-md-12 col-sm-12 d-flex justify-content-center align-items-center mt-3'>
                          <input type = 'submit' value = 'UPDATE' class = 'p-2 btn btn-outline-success'>
                    </div>
                 
                </div>
            </form>
        </div>";


    }

}

?>

    <div class='modal fade' id='messageModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel'
        aria-hidden='true'>
        <div class='modal-dialog' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='exampleModalLabel'>Message</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;
                        </span>
                    </button>
                </div>
                <div class='modal-body' id='messageBody'>

                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-danger' data-dismiss='modal'>Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src='bootstrap/js/bootstrap.js'></script>
    <script src='js/time.js'></script>
    <script>
    //MESSAGE SHOW AFTER UPDATE AJAX
    function showModal(message) {
        document.getElementById('messageBody').innerHTML = message;
        var modal = new bootstrap.Modal(document.getElementById('messageModal'));
        modal.show();

        var modalDismissButtons = messageModal.querySelectorAll('[data-dismiss="modal"]');
        modalDismissButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                messageModal.classList.remove('show');

                // Remove the modal backdrop to remove the fade effect
                var modalBackdrop = document.querySelector('.modal-backdrop');
                if (modalBackdrop) {
                    modalBackdrop.parentNode.removeChild(modalBackdrop);
                }
            });
        });

    }

    // UPDATE AJAX

    function updateAttendance(event) {

        event.preventDefault();
        var form = event.target;
        var formData = new FormData(form);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'controller/attendace_update.php', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log(xhr.responseText);
                showModal(xhr.responseText);
            } else {
                showModal('An error occurred while updating.');
            }
        };

        xhr.send(formData);
    }

    var form = document.getElementById('attendanceUpdate');
    form.addEventListener('submit', updateAttendance);
    </script>
</body>

</html>