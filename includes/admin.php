<?php
session_start();
include( '../includes/db_connect.php' );
include( '../common/common_function.php' );
include( '../model/Bus.class.php' );
include( '../model/Attendance.class.php' );

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

?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Transport Vehicle Attendace System</title>

    <link rel='icon' type='../image/x-icon' href='img/icon.png'>
    <link rel='stylesheet' href='../bootstrap/css/bootstrap.min.css'>
    <link rel='stylesheet' href='../css/style2.css'>
    <script src='../bootstrap/js/bootstrap.js'></script>
    <script src='../DataTables/jQuery-3.7.0/jquery-3.7.0.min.js'></script>
    <link rel='stylesheet' type='text/css' href='../DataTables/css/jquery.dataTables.css'>
</head>

<body>
    <div class='menu-toggle'>
        <div class='bar'></div>
        <div class='bar'></div>
        <div class='bar'></div>
    </div>
    <div class='wrapper'>

        <div class='menu'>

            <ul>
                <li class='menu-item ' onclick="window.location.href='../index.php'">Home</li>

                <li class='menu-item active' data-target='bus'>Manage Buses</li>
                <li class='menu-item ' data-target='report'>Manage Report</li>

            </ul>
        </div>
        <div class='content'>
            <div class='bus active'>

                <div id='bus-view-edit' class='bus-view-edit'>
                    <h2 class='bg-dark text-light text-center p-2'>Manage Bus Detail</h2>
                    <table class=' table table-dark hover pt-3 display cell-border' id='busData'>

                        <thead class=''>
                            <tr>

                                <th class='text-center' scope='col'>Vehicle No</th>
                                <th class='text-center' scope='col'>Route No</th>
                                <th class='text-center' scope='col'>Route</th>
                                <th class='text-center' scope='col'>Type</th>
                                <th class='text-center' scope='col'>Route Distance 1</th>
                                <th class='text-center' scope='col'>Route Distance 2</th>
                                <th class='text-center' scope='col'>Edit</th>
                                <th class='text-center' scope='col'>Delete</th>

                            </tr>
                        </thead>
                        <tbody>

                            <?php
//View all bus data

Bus::viewAll( $conn );

?>

                        </tbody>
                    </table>
                    <div id='edit-form' class='edit-form'>
                        <!-- Your edit form goes here -->

                        <form class='mt-3 p-3 border border-info' method='POST' id='formEdit'>
                            <input type='hidden' name='id' class='form-control mb-2'>
                            <input type='text' name='vehicle_no' placeholder='Vehicle No' class='form-control mb-2'>
                            <input type='text' name='route_no' placeholder='Route No' class='form-control mb-2'>
                            <input type='text' name='route' placeholder='Route' class='form-control mb-2'>
                            <select name='type' class='form-control mb-2'>
                                <option value='shift' id='shift'>Shift</option>
                                <option value='normal' id='normal'>Normal ( 8 - 4 )</option>
                            </select>
                            <input type='number' step='0.01' name='route_distance1' placeholder='Route Distance 1'
                                class='form-control mb-2'>
                            <input type='number' step='0.01' name='route_distance2' placeholder='Route Distance 2'
                                class='form-control mb-2'>
                            <input type='submit' class='btn btn-primary' value='Update'>
                        </form>
                        <button type='button' class='btn btn-success mt-2' onclick=showTable();>Go Back To
                            Table</button>
                    </div>
                    <!--<div id = 'editFormDiv'>
<form id = 'editForm'>

<input type = 'hidden' name = 'id' id = 'editId'>
<input type = 'text' name = 'vehicleNo' id = 'vehicleNo' placeholder = 'route_name'>
<input type = 'text' name = 'routeNo' id = 'routeNo' placeholder = 'route_name'>
<input type = 'text' name = 'route' id = 'route' placeholder = 'route_name'>
<input type = 'text' name = 'type' id = 'type' placeholder = 'route_name'>
<input type = 'number' name = 'routeDistance1' id = 'routeDistance1' placeholder = 'route_name'>
<input type = 'number' name = 'routeDistance2' id = 'routeDistance2' placeholder = 'route_name'>

Add more input fields as needed
<button type = 'submit'>Save Changes</button>
</form>
</div>-->
                    <button type=' button' class='btn btn-primary mt-3' data-bs-toggle='modal'
                        data-bs-target='#myModal'>
                        Add New Route
                    </button>

                    <div class='fade modal' id='myModal'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>

                                <!-- Modal Header -->
                                <div class='modal-header'>
                                    <h4 class='modal-title'>Add New Route</h4>

                                    <button type='button' class='btn-close' data-bs-dismiss='modal'></button>

                                </div>

                                <!-- Modal body -->
                                <div class='modal-body'>
                                    <form method='POST' id='route'>
                                        <div class='mb-3'>

                                            <input type='text' class='form-control' id='vehicle_no'
                                                aria-describedby='nameHelp' name='vehicle_no' placeholder='VEHICLE NO'>

                                        </div>
                                        <div class='mb-3'>

                                            <input type='text' class='form-control' id='route_no'
                                                aria-describedby='nameHelp' name='route_no' placeholder='ROUTE NO'
                                                required>

                                        </div>

                                        <div class='mb-3'>

                                            <input type='text' class='form-control' id='route_name'
                                                aria-describedby='nameHelp' name='route_name' placeholder='ROUTE NAME'
                                                required>

                                        </div>
                                        <div class='mb-3'>

                                            <select name='type' id='type' class='form-control'>
                                                <option value='shift'>Shift</option>
                                                <option value='normal'>Normal ( 8 - 4 )</option>
                                            </select>

                                        </div>
                                        <div class='mb-3'>

                                            <input type='number' step='0.01' class='form-control' id='route_distance1'
                                                aria-describedby='nameHelp' name='route_distance1'
                                                placeholder='ROUTE DISTANCE ' required>

                                        </div>
                                        <div class='mb-3'>

                                            <input type='number' step='0.01' class='form-control' id='route_distance2'
                                                aria-describedby='nameHelp' name='route_distance2'
                                                placeholder='ADDITIONAL MILAGE' required>

                                        </div>
                                        <button type='submit' class='btn btn-primary'>Submit</button>
                                    </form>
                                    <div id='successMsg' style='display:none; color:green;'>Form submitted successfully!
                                    </div>
                                    <div id='errorMsg' style='display:none; color:red;'>Error submitting form. Please
                                        try again.</div>
                                </div>

                                <!-- Modal footer -->
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-danger' data-bs-dismiss='modal'>Close</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class='report'>
                <div id='att-view-edit' class='att-view-edit'>
                    <h2 class='bg-dark text-light text-center p-2'>Manage Bus Detail</h2>
                    <table class=' table table-dark hover pt-3 display cell-border' id='attendanceTable'>

                        <input type='date' id='startDate' name='startDate' class='m-2 p-1'>

                        <input type='date' id='endDate' name='endDate' class='p-1'>

                        <input type='text' id='routeNoSearch' class='m-2 p-1' placeholder='Search By Route No'>
                        <label for='turncount'>Turn Count
                            <input type='text' name='' id='turncount' placeholder='Turn Count' class='m-2 p-1'></label>
                        <label for='km'>Full Km
                            <input type='text' name='' id='km' placeholder='All Distance KM' class='m-2 p-1'></label>

                        <thead class=''>
                            <tr>

                                <th class='text-center' scope='col'>Route No</th>
                                <th class='text-center' scope='col'>Route Name</th>
                                <th class='text-center' scope='col'>Vehicle No</th>
                                <th class='text-center' scope='col'>Driver</th>
                                <th class='text-center' scope='col'>Helper</th>
                                <th class='text-center' scope='col'>Staff Count</th>
                                <th class='text-center' scope='col'>Date</th>
                                <th class='text-center' scope='col'>Mark In Time</th>
                                <th class='text-center' scope='col'>Mark Out</th>
                                <th class='text-center' scope='col'>Status</th>
                                <!-- <th class = 'text-center' scope = 'col'>Created At</th>-->
                                <th class='text-center' scope='col'>Updated At</th>
                                <th class='text-center' scope='col'>Turn Count</th>
                                <th class='text-center' scope='col'>Full Km </th>
                                <th class='text-center' scope='col'>Additional </th>
                                <th class='text-center' scope='col'>Edit</th>
                                <th class='text-center' scope='col'>Delete</th>

                            </tr>
                        </thead>
                        <tbody>

                            <?php
//View all bus data

Attendance::viewAllAttendanceForBack( $conn );

?>

                        </tbody>
                        <button class='btn btn-success' id='exportBtn'> Export Data To Excel File</button>
                        <button class='btn btn-success m-2' id='exportBtn1'> Calculation Report</button>
                    </table>
                    <div id='att-edit-form' class='att-edit-form'>
                        <!-- Your edit form goes here -->

                        <form class='mt-3 p-3 border border-info' method='POST' id='formAttEdit'>
                            <input type='hidden' name='attid' class='form-control mb-2'>
                            <div class='col-lg-12 col-md-12 col-sm-12 d-flex justify-content-center align-items-center'>
                                <label for='vehicleNo' class='form-label w-100 text-center'>Vehicle No
                                    <input name='vehicle_no' class='form-control ' type='text' placeholder='Vehicle No'
                                        aria-label='.form-control-lg example'></label>
                            </div>

                            <div class='col-lg-12 col-md-12 col-sm-12 d-flex justify-content-center align-items-center'>
                                <label for='staff_count' class='form-label w-100 text-center'>Staff Count
                                    <input name='staff_count' class='form-control ' type='text'
                                        placeholder='Staff Count' aria-label=' .form-control-lg example'></label>
                            </div>
                            <div class='col-lg-12 col-md-12 col-sm-12 d-flex justify-content-center align-items-center'>
                                <label for='route_distance' class='form-label w-100 text-center'>Full Rount Distance
                                    <input name='route_distance' class='form-control ' type='number' step='0.01'
                                        placeholder='Route Distance' aria-label=' .form-control-lg example'></label>
                            </div>
                            <div class='col-lg-12 col-md-12 col-sm-12 d-flex justify-content-center align-items-center'>
                                <label for='endTime' class='form-label w-100 text-center'>In Time
                                    <input type='time' name='startTime' id='startTime' class='form-control  '></label>
                            </div>
                            <div class='col-lg-12 col-md-12 col-sm-12 d-flex justify-content-center align-items-center'>
                                <label for='endTime' class='form-label w-100 text-center'>Out Time
                                    <input type='time' name='endTime' id='endTime' class='form-control'></label>
                            </div>

                            <!--additiona km update -->

                            <div class='col-lg-12 col-md-12 col-sm-12 d-flex justify-content-center align-items-center'>
                                <label for='additional_in' class='form-label w-100 text-center'>Additional In
                                    <input type='text' name='additional_in' id='additional_in'
                                        class='form-control  '></label>
                            </div>
                            <div class='col-lg-12 col-md-12 col-sm-12 d-flex justify-content-center align-items-center'>
                                <label for='additional_out' class='form-label w-100 text-center'>Additional Out
                                    <input type='text' name='additional_out' id='additional_out'
                                        class='form-control'></label>
                            </div>

                            <div class='col-lg-12 col-md-12 col-sm-12 d-flex justify-content-center align-items-center'>
                                <label for='status' class='form-label w-100 text-center'>Status
                                    <input name='status' class='form-control ' type='text' placeholder='Status'
                                        aria-label=' .form-control-lg example'></label>
                            </div>

                            <div class='d-flex justify-content-center align-items-center mt-2'>
                                <div class='checkbox-group'>
                                    <label>
                                        <input type='checkbox' name='driver' value='1'> Driver
                                    </label>
                                    <label>
                                        <input type='checkbox' name='helper' value='1'> Helper
                                    </label>
                                </div>
                            </div>

                            <input type='submit' class='btn btn-primary' value='Update'>
                        </form>
                        <button type='button' class='btn btn-success mt-2' onclick=showTableAtt();>Go Back To
                            Table</button>
                    </div>
                    <!--<div id = 'editFormDiv'>
<form id = 'editForm'>

<input type = 'hidden' name = 'id' id = 'editId'>
<input type = 'text' name = 'vehicleNo' id = 'vehicleNo' placeholder = 'route_name'>
<input type = 'text' name = 'routeNo' id = 'routeNo' placeholder = 'route_name'>
<input type = 'text' name = 'route' id = 'route' placeholder = 'route_name'>
<input type = 'text' name = 'type' id = 'type' placeholder = 'route_name'>
<input type = 'number' name = 'routeDistance1' id = 'routeDistance1' placeholder = 'route_name'>
<input type = 'number' name = 'routeDistance2' id = 'routeDistance2' placeholder = 'route_name'>

Add more input fields as needed
<button type = 'submit'>Save Changes</button>
</form>
</div>-->
                </div>
                <!--<div id = 'attendance-view-edit' class = 'attendance-view-edit'>
<h2 class = 'bg-dark text-light text-center p-2'>Manage Attendance Detail</h2>
<table class = ' table table-dark hover pt-3 display cell-border' id = 'attendanceTable'>

<input type = 'date' id = 'startDate' name = 'startDate' class = 'm-2 p-1'>

<input type = 'date' id = 'endDate' name = 'endDate' class = 'p-1'>

<input type = 'text' id = 'routeNoSearch' class = 'm-2 p-1' placeholder = 'Search By Route No'>
<label for = 'turncount'>Turn Count
<input type = 'text' name = '' id = 'turncount' placeholder = 'Turn Count' class = 'm-2 p-1'></label>
<thead class = ''>
<tr>
<th class = 'text-center' scope = 'col'>Route No</th>
<th class = 'text-center' scope = 'col'>Route Name</th>
<th class = 'text-center' scope = 'col'>Vehicle No</th>
<th class = 'text-center' scope = 'col'>Driver</th>
<th class = 'text-center' scope = 'col'>Helper</th>
<th class = 'text-center' scope = 'col'>Staff Count</th>
<th class = 'text-center' scope = 'col'>Date</th>
<th class = 'text-center' scope = 'col'>Mark In Time</th>
<th class = 'text-center' scope = 'col'>Mark Out</th>
<th class = 'text-center' scope = 'col'>Status</th>
<th class = 'text-center' scope = 'col'>Created At</th>
<th class = 'text-center' scope = 'col'>Updated At</th>
<th class = 'text-center' scope = 'col'>Turn Count</th>
<th class = 'text-center' scope = 'col'>Edit</th>
<th class = 'text-center' scope = 'col'>Delete</th>

</tr>
</thead>
<tbody>

<?php

Attendance::viewAllAttendanceForBack( $conn );

?>

</tbody>

</table>
<div id = 'edit-form' class = 'edit-form'>
Your edit form goes here

<form class = 'mt-3 p-3 border border-info' method = 'POST' id = 'formEdit'>
<input type = 'hidden' name = 'id' class = 'form-control mb-2'>
<input type = 'text' name = 'vehicle_no' placeholder = 'Vehicle No' class = 'form-control mb-2'>
<input type = 'text' name = 'route_no' placeholder = 'Route No' class = 'form-control mb-2'>
<input type = 'text' name = 'route' placeholder = 'Route' class = 'form-control mb-2'>
<select name = 'type' class = 'form-control mb-2'>
<option value = 'shift' id = 'shift'>Shift</option>
<option value = 'normal' id = 'normal'>Normal ( 8 - 4 )</option>
</select>
<input type = 'number' step = '0.01' name = 'route_distance1' placeholder = 'Route Distance 1'

class = 'form-control mb-2'>
<input type = 'number' step = '0.01' name = 'route_distance2' placeholder = 'Route Distance 2'

class = 'form-control mb-2'>
<input type = 'submit' class = 'btn btn-primary' value = 'Update'>
</form>
<button type = 'button' class = 'btn btn-success mt-2' onclick = showTable();
>Go Back To
Table</button>
</div>
<div id = 'editFormDiv'>
<form id = 'editForm'>

<input type = 'hidden' name = 'id' id = 'editId'>
<input type = 'text' name = 'vehicleNo' id = 'vehicleNo' placeholder = 'route_name'>
<input type = 'text' name = 'routeNo' id = 'routeNo' placeholder = 'route_name'>
<input type = 'text' name = 'route' id = 'route' placeholder = 'route_name'>
<input type = 'text' name = 'type' id = 'type' placeholder = 'route_name'>
<input type = 'number' name = 'routeDistance1' id = 'routeDistance1' placeholder = 'route_name'>
<input type = 'number' name = 'routeDistance2' id = 'routeDistance2' placeholder = 'route_name'>

Add more input fields as needed
<button type = 'submit'>Save Changes</button>
</form>
</div>
</div>-->
            </div>
            <!-- Add more content as needed -->
        </div>
    </div>
    <script type='text/javascript' charset='utf8' src='../DataTables/js/jquery.dataTables.js'>
    </script>
    <script>
    document.getElementById('exportBtn1').addEventListener('click', function() {

        var startDate = document.getElementById('startDate').value;
        var endDate = document.getElementById('endDate').value;
        var routeNo = document.getElementById('routeNoSearch').value;

        var isCheckSet = true;
        var url = '../fetch_calculation_report.php?startDate=' + startDate + '&endDate=' + endDate +
            '&routeNo=' +
            routeNo +
            '&isCheckSet=' + isCheckSet;
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var records = JSON.parse(xhr.responseText);
                    // Process records and export to Excel
                    console.log(records);
                    exportRecordsToExcel(records, startDate, endDate);
                } else {
                    console.error('Error fetching records:', xhr.status, xhr.statusText);
                }
            }
        };

        xhr.open('GET', url, true);
        xhr.send();


    });

    function exportRecordsToExcel(records, startDate, endDate) {
        // Use SheetJS or another library to create an Excel file
        // Trigger a download or save the file
        // Example using SheetJS:
        var wb = XLSX.utils.book_new();
        var ws = XLSX.utils.json_to_sheet(records);
        XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');

        // Format the start and end date for the file name
        var formattedStartDate = startDate.replace(/-/g, '');
        var formattedEndDate = endDate.replace(/-/g, '');

        // Construct the file name with start and end date
        var fileName = 'final_calculated_attendance_data_' + formattedStartDate + '_to_' + formattedEndDate + '.xlsx';

        // Trigger a download or save the file
        XLSX.writeFile(wb, fileName);
    }
    </script>
    <script src='../js/admin.js'></script>
    <script src=' ../FileSaver.js-master/FileSaver.min.js'></script>
    <script src='../sheetjs-github/dist/xlsx.full.min.js'></script>
</body>

</html>