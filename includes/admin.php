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


    <link rel="icon" type="../image/x-icon" href="img/icon.png">
    <link rel='stylesheet' href='../bootstrap/css/bootstrap.min.css'>
    <link rel='stylesheet' href='../css/style2.css'>
    <script src='../bootstrap/js/bootstrap.js'></script>
    <script src="../DataTables/jQuery-3.7.0/jquery-3.7.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../DataTables/css/jquery.dataTables.css">
</head>

<body>
    <div class="menu-toggle">
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
    </div>
    <div class='wrapper'>

        <div class='menu'>

            <ul>
                <li class="menu-item " onclick="window.location.href='../index.php'">Home</li>

                <li class="menu-item active" data-target="bus">Manage Buses</li>
                <li class="menu-item " data-target="report">Manage Report</li>


            </ul>
        </div>
        <div class='content'>
            <div class='bus active'>


                <div id="bus-view-edit" class="bus-view-edit">
                    <h2 class="bg-dark text-light text-center p-2">Manage Bus Detail</h2>
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

                        Bus::viewAll($conn);
                    
                        ?>

                        </tbody>
                    </table>
                    <div id="edit-form" class='edit-form'>
                        <!-- Your edit form goes here -->

                        <form class='mt-3 p-3 border border-info' method='POST' id='formEdit'>
                            <input type='hidden' name='id' class='form-control mb-2'>
                            <input type='text' name='vehicle_no' placeholder='Vehicle No' class='form-control mb-2'>
                            <input type='text' name='route_no' placeholder='Route No' class='form-control mb-2'>
                            <input type='text' name='route' placeholder='Route' class='form-control mb-2'>
                            <select name='type' class='form-control mb-2'>
                                <option value='shift' id='shift'>Shift</option>
                                <option value='normal' id='normal'>Normal (8 - 4)</option>
                            </select>
                            <input type='number' step="0.01" name='route_distance1' placeholder='Route Distance 1'
                                class='form-control mb-2'>
                            <input type='number' step="0.01" name='route_distance2' placeholder='Route Distance 2'
                                class='form-control mb-2'>
                            <input type='submit' class='btn btn-primary' value='Update'>
                        </form>
                        <button type="button" class='btn btn-success mt-2' onclick=showTable();>Go Back To
                            Table</button>
                    </div>
                    <!--<div id="editFormDiv">
                        <form id="editForm">

                            <input type="hidden" name="id" id="editId">
                            <input type="text" name="vehicleNo" id="vehicleNo" placeholder='route_name'>
                            <input type="text" name="routeNo" id="routeNo" placeholder='route_name'>
                            <input type="text" name="route" id="route" placeholder='route_name'>
                            <input type="text" name="type" id="type" placeholder='route_name'>
                            <input type="number" name="routeDistance1" id="routeDistance1" placeholder='route_name'>
                            <input type="number" name="routeDistance2" id="routeDistance2" placeholder='route_name'>

                           Add more input fields as needed 
                    <button type="submit">Save Changes</button>
                    </form>
                   </div>-->
                    <button type=" button" class="btn btn-primary mt-3" data-bs-toggle="modal"
                        data-bs-target="#myModal">
                        Add New Route
                    </button>

                    <div class="fade modal" id="myModal">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Add New Route</h4>

                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                                </div>


                                <!-- Modal body -->
                                <div class="modal-body">
                                    <form method='POST' id='route'>
                                        <div class="mb-3">

                                            <input type="text" class="form-control" id="vehicle_no"
                                                aria-describedby="nameHelp" name='vehicle_no' placeholder='VEHICLE NO'>

                                        </div>
                                        <div class="mb-3">

                                            <input type="text" class="form-control" id="route_no"
                                                aria-describedby="nameHelp" name='route_no' placeholder='ROUTE NO'
                                                required>

                                        </div>

                                        <div class="mb-3">

                                            <input type="text" class="form-control" id="route_name"
                                                aria-describedby="nameHelp" name='route_name' placeholder='ROUTE NAME'
                                                required>

                                        </div>
                                        <div class="mb-3">

                                            <select name="type" id="type" class="form-control">
                                                <option value="shift">Shift</option>
                                                <option value="normal">Normal (8 - 4)</option>
                                            </select>

                                        </div>
                                        <div class="mb-3">

                                            <input type="number" step="0.01" class="form-control" id="route_distance" 1
                                                aria-describedby="nameHelp" name='route_distance1'
                                                placeholder='ROUTE DISTANCE 1' required>

                                        </div>
                                        <div class="mb-3">

                                            <input type="number" step="0.01" class="form-control" id="route_distance2"
                                                aria-describedby="nameHelp" name='route_distance2'
                                                placeholder='ROUTE DISTANCE 2' required>

                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                    <div id="successMsg" style="display:none; color:green;">Form submitted successfully!
                                    </div>
                                    <div id="errorMsg" style="display:none; color:red;">Error submitting form. Please
                                        try again.</div>
                                </div>

                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>




            </div>
            <div class='report'>
                <div id="att-view-edit" class="att-view-edit">
                    <h2 class="bg-dark text-light text-center p-2">Manage Bus Detail</h2>
                    <table class=' table table-dark hover pt-3 display cell-border' id='attendanceTable'>

                        <input type="date" id="startDate" name="startDate" class='m-2 p-1'>



                        <input type="date" id="endDate" name="endDate" class='p-1'>


                        <input type="text" id="routeNoSearch" class="m-2 p-1" placeholder='Search By Route No'>
                        <label for="turncount">Turn Count
                            <input type="text" name="" id="turncount" placeholder='Turn Count' class="m-2 p-1"></label>
                        <label for="km">Full Km
                            <input type="text" name="" id="km" placeholder='All Distance KM' class="m-2 p-1"></label>

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
                                <th class='text-center' scope='col'>Created At</th>
                                <th class='text-center' scope='col'>Updated At</th>
                                <th class='text-center' scope='col'>Turn Count</th>
                                <th class='text-center' scope='col'>Full Km </th>
                                <th class='text-center' scope='col'>Edit</th>
                                <th class='text-center' scope='col'>Delete</th>

                            </tr>
                        </thead>
                        <tbody>

                            <?php
                        //View all bus data

                         Attendance::viewAllAttendanceForBack($conn);
                    
                        ?>

                        </tbody>
                    </table>
                    <div id="att-edit-form" class='att-edit-form'>
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
                                    <input name='route_distance' class='form-control ' type='number' step="0.01"
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
                        <button type="button" class='btn btn-success mt-2' onclick=showTableAtt();>Go Back To
                            Table</button>
                    </div>
                    <!--<div id="editFormDiv">
                        <form id="editForm">

                            <input type="hidden" name="id" id="editId">
                            <input type="text" name="vehicleNo" id="vehicleNo" placeholder='route_name'>
                            <input type="text" name="routeNo" id="routeNo" placeholder='route_name'>
                            <input type="text" name="route" id="route" placeholder='route_name'>
                            <input type="text" name="type" id="type" placeholder='route_name'>
                            <input type="number" name="routeDistance1" id="routeDistance1" placeholder='route_name'>
                            <input type="number" name="routeDistance2" id="routeDistance2" placeholder='route_name'>

                           Add more input fields as needed 
                    <button type="submit">Save Changes</button>
                    </form>
                   </div>-->
                </div>
                <!--<div id="attendance-view-edit" class="attendance-view-edit">
                    <h2 class="bg-dark text-light text-center p-2">Manage Attendance Detail</h2>
                    <table class=' table table-dark hover pt-3 display cell-border' id='attendanceTable'>

                        <input type="date" id="startDate" name="startDate" class='m-2 p-1'>



                        <input type="date" id="endDate" name="endDate" class='p-1'>


                        <input type="text" id="routeNoSearch" class="m-2 p-1" placeholder='Search By Route No'>
                        <label for="turncount">Turn Count
                            <input type="text" name="" id="turncount" placeholder='Turn Count' class="m-2 p-1"></label>
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
                                <th class='text-center' scope='col'>Created At</th>
                                <th class='text-center' scope='col'>Updated At</th>
                                <th class='text-center' scope='col'>Turn Count</th>
                                <th class='text-center' scope='col'>Edit</th>
                                <th class='text-center' scope='col'>Delete</th>

                            </tr>
                        </thead>
                        <tbody>

                            <?php
                        

                       Attendance::viewAllAttendanceForBack($conn);
                    
                        ?>

                        </tbody>

                    </table>
                    <div id="edit-form" class='edit-form'>
                     Your edit form goes here 

                        <form class='mt-3 p-3 border border-info' method='POST' id='formEdit'>
                            <input type='hidden' name='id' class='form-control mb-2'>
                            <input type='text' name='vehicle_no' placeholder='Vehicle No' class='form-control mb-2'>
                            <input type='text' name='route_no' placeholder='Route No' class='form-control mb-2'>
                            <input type='text' name='route' placeholder='Route' class='form-control mb-2'>
                            <select name='type' class='form-control mb-2'>
                                <option value='shift' id='shift'>Shift</option>
                                <option value='normal' id='normal'>Normal (8 - 4)</option>
                            </select>
                            <input type='number' step="0.01" name='route_distance1' placeholder='Route Distance 1'
                                class='form-control mb-2'>
                            <input type='number' step="0.01" name='route_distance2' placeholder='Route Distance 2'
                                class='form-control mb-2'>
                            <input type='submit' class='btn btn-primary' value='Update'>
                        </form>
                        <button type="button" class='btn btn-success mt-2' onclick=showTable();>Go Back To
                            Table</button>
                    </div>
                    <div id="editFormDiv">
                        <form id="editForm">

                            <input type="hidden" name="id" id="editId">
                            <input type="text" name="vehicleNo" id="vehicleNo" placeholder='route_name'>
                            <input type="text" name="routeNo" id="routeNo" placeholder='route_name'>
                            <input type="text" name="route" id="route" placeholder='route_name'>
                            <input type="text" name="type" id="type" placeholder='route_name'>
                            <input type="number" name="routeDistance1" id="routeDistance1" placeholder='route_name'>
                            <input type="number" name="routeDistance2" id="routeDistance2" placeholder='route_name'>

                           Add more input fields as needed 
                    <button type="submit">Save Changes</button>
                    </form>
                </div>
                </div>-->
            </div>
            <!-- Add more content as needed -->
        </div>
    </div>
    <script type="text/javascript" charset="utf8" src="../DataTables/js/jquery.dataTables.js">
    </script>
    <script>
    //submit edit form

    //data table 

    $(document).ready(function() {
        $('#busData').DataTable({
            "order": [
                [1, "asc"],

            ],
            "pageLength": 20,
            "lengthMenu": [
                [10, 20, -1],
                [10, 20, "All"]
            ],
        });
    });

    $(document).ready(function() {
        var table = $('#attendanceTable').DataTable({
                "order": [
                    [10, "desc"],

                ],
                "pageLength": 52, // Set default to 60 rows per page
                "lengthMenu": [
                    [25, 50, 100, -1],
                    [25, 50, 100, "All"]
                ],

                initComplete: function() {
                    this.api().columns().every(function() {
                        var column = this;

                        if ($(column.header()).hasClass('searchable')) {
                            var input = $('<input type="text" class="form-control">')
                                .appendTo($(column.footer()).empty())
                                .on('keyup', function() {
                                    column.search(this.value).draw();
                                });
                        }
                    });

                    $('#routeNoSearch').on('keyup', function() {
                        var routeNo = this.value;
                        table.column(0).search(routeNo === '' ? '' : '^' + routeNo + '$', true,
                            false).draw();
                        calculateSum();
                    });
                },
            }

        );


        //calculate turn count
        function calculateSum() {
            var columnIdxToSum = 13; // Assuming 7th column (index 6) is the column you want to sum
            var filteredData = table.column(columnIdxToSum, {
                "filter": "applied"
            }).data();
            var sum = filteredData.reduce(function(acc, curr) {
                return acc + parseFloat(curr);
            }, 0);


            var columnIdxToSum = 12; // Assuming 7th column (index 6) is the column you want to sum
            var filteredData = table.column(columnIdxToSum, {
                "filter": "applied"
            }).data();
            var sumTurn = filteredData.reduce(function(acc, curr) {
                return acc + parseFloat(curr);
            }, 0);
            var roundedSum = sum.toFixed(2);
            document.getElementById('km').value = roundedSum;
            document.getElementById('turncount').value = sumTurn;
            console.log('Sum of column:', sum);
            console.log('Sum of column:', sumTurn);
        }

        calculateSum();
        //SEARCH BETWEEN TWO DATE

        $('#startDate, #endDate').on('change', function() {
            table.draw();
            calculateSum();
        });

        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var startDate = $('#startDate').val();
                var endDate = $('#endDate').val();

                if ((startDate === '' && endDate === '') ||
                    (startDate <= data[6] && endDate >= data[6]) || startDate == data[6]) {
                    return true;
                }

                return false;
            }
        );
    });

    document.addEventListener('DOMContentLoaded', function() {
        const menuItems = document.querySelectorAll('.menu-item');
        const contentSections = document.querySelectorAll('.content > div');
        const menuToggle = document.querySelector('.menu-toggle');
        const menu = document.querySelector('.menu');


        menuToggle.addEventListener('click', function() {
            menu.classList.toggle('default');
            this.classList.toggle('rotate');
        });
        menuItems.forEach(item => {
            item.addEventListener('click', function() {
                const target = this.getAttribute('data-target');
                //alert(target);
                contentSections.forEach(section => {
                    section.classList.remove('active');
                });
                document.querySelector(`.${target}`).classList.add('active');

                menuItems.forEach(menuItem => {
                    menuItem.classList.remove('active');
                });
                this.classList.add('active');
            });
        });
    });



    //edit and move between edit and form

    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit');
        var xhr = new XMLHttpRequest();
        editButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const id = this.getAttribute('data-id');
                console.log(id);

                xhr.open('GET', '../get_edit_form.php?id=' + id, true);

                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 400) {
                        document.getElementById('busData').style.display = 'none';
                        document.getElementById('edit-form').classList.add('show');
                        var response = JSON.parse(xhr.responseText);

                        // Set values to form fields
                        document.querySelector('[name="id"]').value = response.id;
                        document.querySelector('[name="vehicle_no"]').value = response
                            .vehicle_no;
                        document.querySelector('[name="route_no"]').value = response
                            .route_no;
                        document.querySelector('[name="route"]').value = response.route;


                        var type = response.type;

                        // console.log(type);

                        var shiftOption = '';
                        if (type == 'shift') {
                            shiftOption = document.getElementById('shift');
                            shiftOption.setAttribute('selected', 'selected');
                        } else if (type = 'normal') {
                            shiftOption = document.getElementById('normal');
                            shiftOption.setAttribute('selected', 'selected');
                        }

                        document.querySelector('[name="route_distance1"]').value = response
                            .route_distance1;
                        document.querySelector('[name="route_distance2"]').value = response
                            .route_distance2;
                    }
                };

                xhr.send();




            });
        });
    });


    // move attendance table and edit form

    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit_att');
        var xhr = new XMLHttpRequest();
        editButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const id = this.getAttribute('data-id');
                console.log(id);

                xhr.open('GET', '../get_edit_form.php?attid=' + id, true);

                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 400) {
                        document.getElementById('attendanceTable').style.display = 'none';
                        document.getElementById('att-edit-form').classList.add('show');
                        var response = JSON.parse(xhr.responseText);

                        // Set values to form fields
                        document.querySelector('#formAttEdit [name="attid"]').value =
                            response
                            .id;
                        document.querySelector('#formAttEdit [name="vehicle_no"]').value =
                            response.vehicle_no;
                        document.querySelector('#formAttEdit [name="staff_count"]').value =
                            response.staff_count;

                        document.querySelector('#formAttEdit [name="status"]').value =
                            response.status;

                        /*document.querySelector('#formAttEdit [name="turn_count"]').value =
                            response.turn_count;
*/
                        document.querySelector('#formAttEdit [name="route_distance"]')
                            .value =
                            response.route_distance;

                        console.log(response.route_distance)
                        console.log(response.turn_count);


                        if (response.checked1 === 'checked') {
                            document.querySelector('input[name="driver"]').checked = true;
                        }

                        if (response.checked2 === 'checked') {
                            document.querySelector('input[name="helper"]').checked = true;
                        }

                        document.querySelector('#formAttEdit [name="startTime"]')
                            .value =
                            response.mark_in;

                        document.querySelector('#formAttEdit [name="endTime"]')
                            .value =
                            response.mark_out;



                    }
                };

                xhr.send();




            });
        });
    });


    //delete

    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.delete');
        var xhr = new XMLHttpRequest();

        editButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const id = this.getAttribute('data-id');
                //console.log(id);

                // Ask for confirmation
                const confirmed = confirm('Are you sure you want to delete this data?');

                if (confirmed) {
                    xhr.open('GET', '../controller/bus_delete_process.php?delid=' + id, true);

                    xhr.onload = function() {
                        if (xhr.status >= 200 && xhr.status < 400) {

                            //console.log(xhr.responseText);
                            if (xhr.responseText == 'Deleted Succesfully') {
                                alert('Data Deleted Succesfully');
                                window.location.reload();

                            }

                        }
                    };

                    xhr.send();
                }
            });
        });
    });

    //delete att

    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.delete_att');
        var xhr = new XMLHttpRequest();

        editButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const id = this.getAttribute('data-id');
                //console.log(id);

                // Ask for confirmation
                const confirmed = confirm('Are you sure you want to delete this data?');

                if (confirmed) {
                    xhr.open('GET', '../controller/delete_process.php?attdelid=' + id,
                        true);

                    xhr.onload = function() {
                        if (xhr.status >= 200 && xhr.status < 400) {

                            console.log(xhr.responseText);

                            if (xhr.responseText == 'Deleted Succesfully') {

                                alert('Data Deleted Succesfully');

                                location.reload();


                            }

                        }
                    };

                    xhr.send();
                }
            });
        });
    });


    //show table again
    function showTable() {
        document.getElementById('busData').style.display = 'block';
        document.getElementById('edit-form').classList.remove('show');

    }

    function showTableAtt() {
        document.getElementById('attendanceTable').style.display = 'block';
        document.getElementById('att-edit-form').classList.remove('show');

    }
    //showEdit Form function

    // Submit event for edit form


    //edit form update

    document.getElementById('formEdit').addEventListener('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);
        var xhr = new XMLHttpRequest();

        xhr.open('POST', '../controller/bus_process_edit.php', true);

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                if (xhr.responseText == 'Details Updated Succesfully') {
                    alert(xhr.responseText);
                    window.location.reload();
                }
                console.log(xhr.responseText);
            }
        };

        xhr.send(formData);
    });


    //att edit form update 
    document.getElementById('formAttEdit').addEventListener('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);
        var xhr = new XMLHttpRequest();

        xhr.open('POST', '../controller/attendace_update.php', true);

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                if (xhr.responseText == 'Data Upate Success') {
                    alert(xhr.responseText);
                    window.location.reload();
                }
                //console.log(xhr.responseText);
            }
        };

        xhr.send(formData);
    });


    //add new route

    document.getElementById('route').addEventListener('submit', function(event) {
        event.preventDefault();

        var formData = new FormData(this);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../controller/bus_process.php', true);

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                console.log(xhr.responseText);
                var responseText = xhr.responseText;
                if (responseText.includes("This Route No Already Added")) {
                    console.log(xhr.responseText);
                    document.getElementById('errorMsg').style.display = 'block';
                    document.getElementById('successMsg').style.display = 'none';
                    document.getElementById('errorMsg').textContent = responseText;
                } else if (responseText.includes("Success")) {
                    document.getElementById('successMsg').style.display = 'block';
                    document.getElementById('errorMsg').style.display = 'none';
                    document.getElementById('successMsg').textContent = responseText;
                } else {
                    document.getElementById('errorMsg').style.display = 'block';
                    document.getElementById('errorMsg').textContent = responseText;
                }
            } else {
                document.getElementById('errorMsg').style.display = 'block';
            }


            document.getElementById('route').reset();
        };

        xhr.onerror = function() {
            document.getElementById('errorMsg').style.display = 'block';
        };

        xhr.send(formData);
    });

    document.addEventListener('DOMContentLoaded', function() {

        var closeButton = document.querySelector('.btn-close');


        closeButton.addEventListener('click', function() {
            document.getElementById('errorMsg').style.display = 'none';
            document.getElementById('successMsg').style.display = 'none';
        });
    });
    </script>
</body>

</html>