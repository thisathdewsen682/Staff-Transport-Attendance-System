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
    <link rel="icon" type="image/x-icon" href="img/icon.png">
    <link rel='stylesheet' href='bootstrap/css/bootstrap.min.css'>
    <link rel='stylesheet' href='css/style1.css'>
    <script src='bootstrap/js/bootstrap.js'></script>
    <script src='js/time.js'></script>
    <script src="DataTables/js/dataTables.jquery.min.js"></script>
    <script src="DataTables/jQuery-3.7.0/jquery-3.7.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="DataTables/css/jquery.dataTables.css">


    <script>
    // Function to prompt for password and set session variable if correct
    /* function promptForPassword() {
        var enteredPassword = prompt("Please enter the password:");

        // Assuming you have a variable `correctPassword` that contains the correct password.
        var correctPassword = "1";

        if (enteredPassword === correctPassword) {
            // Set a session variable to indicate authentication
            <?php $_SESSION['authenticated'] = true; ?>;
        } else {
            alert("Incorrect password. Access denied.");
            window.location.href = 'index.php'; // Redirect to login page if incorrect
        }
    }

    promptForPassword()*/
    </script>


</head>

<body>
    <?php require_once( 'includes/header.php' );?>

    <div class='table-container '>
        <button type="button" class="btn btn-primary btn-sm">
            <a href="index.php" class="home">HOME</a>
        </button>
        <table class=' table table-dark hover pt-3 display cell-border' id='attendanceTable'>

            <input type="date" id="startDate" name="startDate" class='m-2 p-1'>


            <input type="date" id="endDate" name="endDate" class='p-1'>


            <input type="text" id="routeNoSearch" class="m-2 p-1" placeholder='Search By Route No'>

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
                    <th class='text-center' scope='col'>Edit</th>
                    <th class='text-center' scope='col'>Delete</th>

                </tr>
            </thead>
            <tbody>





                <?php
            
            
            if ( isset( $_GET['rno'] ) && $_GET['rno'] == 'all') {
     $report_id = $_GET[ 'rno' ];
            $report = new Attendance( '', '', '', '', '','','', '', '', '', '', '' );

            $result = $report->viewAllAttendance( $conn,$report );

           

                    while( $row = mysqli_fetch_assoc( $result ) ) {
                    $id = $row['attendance_id'];
                           echo "<tr class = 'table-info text-center'>
                        <td>".$row[ 'route_no' ]."</td>
                        <td>".$row[ 'route' ]."</td>
                        <td>".$row[ 'vehicle_no' ]."</td>
                        <td>".$row[ 'driver' ]."</td>
                        <td>".$row[ 'helper' ]."</td>
                        <td>".$row[ 'staff_count' ]."</td>
                        <td>".$row[ 'date' ]."</td>
                        <td>".$row[ 'mark_in' ]."</td>
                        <td>".$row[ 'mark_out' ]."</td>
                        <td>".$row[ 'status' ]."</td>
                        <td>".$row[ 'created_at' ]."</td> 
                        <td>".$row[ 'updated_at' ]."</td> 
                        <td><a href = 'edit_view.php?rid=$id' class = 'edit'>Edit</td> 
                        <td><a href = 'controller/delete_process.php?delid=$id&rno=$report_id' class = 'btn btn-danger'>Delete</td></td> 
                        </tr>       
                      
                        
                        ";

                    }


            }else if ( isset( $_GET[ 'rno' ] ) ) {
           
            $report_id = $_GET[ 'rno' ];
            $report = new Attendance( '', '', '', '', '', '','','', '', '', '', '' );

            $result = $report->viewAttendanceByID( $conn, $report_id, $report );

           

                    while( $row = mysqli_fetch_assoc( $result ) ) {
                     $id = $row['attendance_id'];

                     
                           echo "<tr class = 'table-info text-center'>
                        <td>".$row[ 'route_no' ]."</td>
                        <td>".$row[ 'route' ]."</td>
                        <td>".$row[ 'vehicle_no' ]."</td>
                          <td>".$row[ 'driver' ]."</td>
                        <td>".$row[ 'helper' ]."</td>
                        <td>".$row[ 'staff_count' ]."</td>
                        <td>".$row[ 'date' ]."</td>
                        <td>".$row[ 'mark_in' ]."</td>
                        <td>".$row[ 'mark_out' ]."</td>
                        <td>".$row[ 'status' ]."</td>
                        <td>".$row[ 'created_at' ]."</td> 
                        <td>".$row[ 'updated_at' ]."</td> 
                        <td><a href = 'edit_view.php?rid=$id'>Edit</td> 
                     <td><a href = 'controller/delete_process.php?delid=$id&rno=$report_id' class = 'btn btn-danger'>Delete</td></td> 
                        </tr>
                      
                        
                        ";

                    }

            }   
        
                    ?>



            </tbody>
            <button class='btn btn-success' id='exportBtn'> Export Data To Excel File</button>


        </table>
    </div>


    <div class="msg">
        <?php
        if(isset( $_SESSION[ 'successmsg' ])){
            echo '<span class="success">'.$_SESSION[ 'successmsg' ].'</span>';
            unset( $_SESSION[ 'successmsg' ]);
        }else if(isset($_SESSION[ 'erromsg' ])){
            
            echo '<span class="error">'.$_SESSION[ 'erromsg' ].'</span>';
            unset($_SESSION[ 'erromsg' ]);
        }
    
    ?>

    </div>


    <script type="text/javascript" charset="utf8" src="DataTables/js/jquery.dataTables.js">
    </script>
    <script>
    $(document).ready(function() {
        var table = $('#attendanceTable').DataTable({
                "order": [
                    [10, "desc"],

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
                    });
                }



            }



        );

        $('#startDate, #endDate').on('change', function() {
            table.draw();
        });

        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var startDate = $('#startDate').val();
                var endDate = $('#endDate').val();

                if ((startDate === '' && endDate === '') ||
                    (startDate <= data[4] && endDate >= data[4])) {
                    return true;
                }

                return false;
            }
        );
    });


    //export to excell

    document.getElementById('exportBtn').addEventListener('click', function() {
        var table = document.getElementById('attendanceTable');
        var ws = XLSX.utils.table_to_sheet(table);
        var wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
        var wbout = XLSX.write(wb, {
            bookType: 'xlsx',
            type: 'binary'
        });

        function s2ab(s) {
            var buf = new ArrayBuffer(s.length);
            var view = new Uint8Array(buf);
            for (var i = 0; i != s.length; ++i) view[i] = s.charCodeAt(i) & 0xFF;
            return buf;
        }
        var blob = new Blob([s2ab(wbout)], {
            type: "application/octet-stream"
        });
        var filename = 'exported_data.xlsx';
        saveAs(blob, filename);
    });
    </script>
    <script src="FileSaver.js-master/FileSaver.min.js"></script>

    <script src="sheetjs-github/dist/xlsx.full.min.js"></script>
</body>

</html>