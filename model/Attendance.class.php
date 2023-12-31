<?php

class Attendance {
    //var $attendance_id;
    var $route_no;
    var $route;
    var $vehicle_no;
    var $driver;
    var $helper;
    var $staff_count;
    var $date;
    var $mark_in;
    var $mark_out;
    var $status;
    var $created_at;
    var $updated_at;
    var $turn_count;
    var $route_distance_in_km;
    var $route_distance_out_km;
    var $additional_in;
    var $additional_out;
    var $updated_ip;
    var $updated_emp_no;

    function  Attendance(
        $route_no, $route, $vehicle_no, $driver, $helper, $staff_count, $date, $mark_in, $mark_out, $status, $created_at, $updated_at, $turn_count, $route_distance_in_km, $route_distance_out_km, $additional_in, $additional_out, $updated_ip, $updated_emp_no
    ) {
        //$this->attendance_id = $attendance_id;
        $this->route_no = $route_no;
        $this->route = $route;
        $this->vehicle_no = $vehicle_no;
        $this->driver = $driver;
        $this->helper = $helper;
        $this->staff_count = $staff_count;
        $this->date = $date;
        $this->mark_in = $mark_in;
        $this->mark_out = $mark_out;
        $this->status = $status;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->turn_count = $turn_count;
        $this->route_distance_in_km = $route_distance_in_km;
        $this->route_distance_out_km = $route_distance_out_km;
        $this->additional_in = $additional_in;
        $this->additional_out = $additional_out;
        $this->updated_ip = $updated_ip;
        $this->updated_emp_no = $updated_emp_no;
    }

    function markAttendace( $conn, $obj ) {

        $checkedSql = 'SELECT * FROM attendance_tbl WHERE route_no = ' . $_POST[ 'route_no' ] . ' AND mark_out IS NULL';

        $checkedStatus = mysqli_query( $conn, $checkedSql );
        //echo mysqli_error( $conn );
        if ( mysqli_num_rows( $checkedStatus ) > 0 ) {

            // Record already exists with no mark out time, do nothing or handle accordingly

            echo 'Already marked In Please Mark Out Befor Mark in Again';

        } else {
            $sql = "INSERT INTO `attendance_tbl` (
                            `route_no` ,
                            `route` ,
                            `vehicle_no` ,
                            `driver` ,
                            `helper` ,
                            `staff_count` ,
                            `date` ,
                            `mark_in` ,
                            `status` ,
                            `created_at` ,
                            `updated_at`,
                            `turn_count`,
                            `route_distance_in_km`,
                            `additional_in`

                            )
                            VALUES (
                            '". $obj->route_no ."', 
                            '". $obj->route ."', 
                            '". $obj->vehicle_no ."', 
                            '". $obj->driver ."', 
                            '". $obj->helper ."', 
                            '". $obj->staff_count ."', 
                            '". $obj->date ."', 
                            '". $obj->mark_in ."', 
                            '". $obj->status ."', 
                            '". $obj->created_at ."',
                            '". $obj->updated_at ."',
                            '". $obj->turn_count ."',
                            '". $obj->route_distance_in_km ."',
                            '". $obj->additional_in ."'
                            );";
            //echo $sql;
            $result = mysqli_query( $conn, $sql );

            return $result;
        }
    }

    function markOut( $conn, $obj, $rno ) {

        $checkedSql = 'SELECT * FROM attendance_tbl WHERE route_no = ' . $rno . ' AND mark_out IS NULL ';

        $checkedStatus = mysqli_query( $conn, $checkedSql );

        //echo mysqli_error( $conn );
        if ( mysqli_num_rows( $checkedStatus ) > 0 ) {

            $sql = "UPDATE attendance_tbl SET mark_out =  '". $obj->mark_out ."', status = '". $obj->status ."', 
            updated_at = '". $obj->updated_at ."', turn_count = '". $obj->turn_count ."' , route_distance_out_km = '". $obj->route_distance_out_km ."', aditional_out = '". $obj->additional_out ."' WHERE route_no = ". $rno .' AND mark_out IS NULL';
            $result = mysqli_query( $conn, $sql );
            return $result;

        } else {
            echo 'Not Marked In';
        }
    }

    function viewAttendanceByID( $conn, $routeNo, $report ) {

        $sql = 'SELECT * FROM   attendance_tbl WHERE route_no = '. $routeNo .'  ORDER BY created_at DESC';
        $result = mysqli_query( $conn, $sql );
        //var_dump( $result );
        return $result;

    }

    function viewAttendanceByID1( $conn, $routeNo, $report ) {

        // $sql = 'SELECT * FROM   attendance_tbl WHERE attendance_id = '. $routeNo .'  ORDER BY created_at DESC';

        $sql = 'SELECT 
    attendance_id, 
    route_no, 
    route, 
    vehicle_no, 
    driver, 
    helper, 
    staff_count, 
    date, 
    mark_in, 
    mark_out, 
    status, 
    created_at, 
    updated_at, 
    turn_count, 
    route_distance_in_km, 
    route_distance_out_km, 
    additional_in, 
    aditional_out, 
    (route_distance_in_km + route_distance_out_km) as full_route_distance_km
   
    FROM 
    attendance_tbl WHERE attendance_id = '. $routeNo .'  ORDER BY created_at DESC;
';
        $result = mysqli_query( $conn, $sql );
        //var_dump( $result );
        return $result;

    }

    function viewAllAttendance( $conn, $report ) {

        $sql = 'SELECT * FROM   attendance_tbl ORDER BY created_at DESC';
        //echo $sql;
        $result = mysqli_query( $conn, $sql );
        return $result;

    }

    function updateAttendanceById( $conn, $att, $id ) {

        $sql = "UPDATE attendance_tbl SET vehicle_no = '".$att->vehicle_no."', driver = '".$att->driver."',helper = '".$att->helper."', staff_count = '".$att->staff_count."', mark_in = '".$att->mark_in."', mark_out = '".
        $att->mark_out."', updated_at = '".$att->updated_at ."',  route_distance_in_km =  '".$att->route_distance_in_km."', route_distance_out_km =  '".$att->route_distance_out_km."', additional_in =  '".$att->additional_in."', aditional_out =  '".$att->additional_out."', updated_ip =  '".$att->updated_ip."', updated_empno =  '".$att->updated_emp_no."' WHERE attendance_id = '".$id."';";
        $result = mysqli_query( $conn, $sql );
        return $result;

    }

    static function deletById( $conn, $id ) {

        $sql = 'DELETE FROM attendance_tbl WHERE attendance_id = '.$id.'';
        $result = mysqli_query( $conn, $sql );

        if ( $result ) {
            echo 'Deleted Succesfully';
        } else {
            echo mysqli_error( $conn, $sql );
            echo 'Something Wrong';
        }
        return $result;
    }

    static function viewAllAttendanceForBack( $conn ) {
        //$sql = 'SELECT * FROM   attendance_tbl ORDER BY created_at DESC';
        $sql = 'SELECT 
    attendance_id, 
    route_no, 
    route, 
    vehicle_no, 
    driver, 
    helper, 
    staff_count, 
    date, 
    mark_in, 
    mark_out, 
    status, 
    created_at, 
    updated_at, 
    turn_count, 
    route_distance_in_km, 
    route_distance_out_km, 
    (route_distance_in_km + route_distance_out_km) as full_route_distance_km,
     (additional_in + aditional_out) as additional_km
FROM 
    attendance_tbl ORDER BY created_at DESC;
';
        $result = mysqli_query( $conn, $sql );

        while( $row = mysqli_fetch_assoc( $result ) ) {
            $id = $row[ 'attendance_id' ];
            $rounded_distance = round( $row[ 'full_route_distance_km' ], 2 );
            $additonal = round( $row[ 'additional_km' ], 2 );

            echo "<tr class='table-info text-center'>
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
                    <td>".$row[ 'updated_at' ]."</td>
                    <td>".$row[ 'turn_count' ]."</td>
                    <td>".$rounded_distance."</td>
                    <td>".$additonal."</td>
                      <td><a href = '#' class = 'edit_att btn btn-success' data-id='{$row['attendance_id']}'>Edit</td>
                <td><a href = '#' class = 'delete_att btn btn-danger' data-id='{$row['attendance_id']}'>Delete</td></td>
                    

                   
                </tr>
                ";

        }
    }

    function viewAttEditFormByID( $conn, $id ) {

        $sql = 'SELECT 
    attendance_id, 
    route_no, 
    route, 
    vehicle_no, 
    driver, 
    helper, 
    staff_count, 
    date, 
    mark_in, 
    mark_out, 
    status, 
    created_at, 
    updated_at, 
    turn_count, 
    route_distance_in_km, 
    route_distance_out_km, 
    additional_in, 
    aditional_out, 
    (route_distance_in_km + route_distance_out_km) as full_route_distance_km
    FROM 
    attendance_tbl  WHERE attendance_id = "'.$id.'"';

        $result = mysqli_query( $conn, $sql );
        if ( $result ) {

        } else {
            mysqli_connect_error( $conn, $result );
        }
        return $result;

    }

    static function getCalculationReport( $conn, $startDate, $endDate, $routeNo ) {
        $records = array();
        // echo $startDate;
        //echo $endDate;
        if ( empty( $routeNo ) ) {
            $sql = "SELECT
            route_no as 'Route Number',
            route as 'Route',
            SUM(turn_count) AS 'No of turns',
            SUM(additional_in + aditional_out) AS 'Additional Mileage(Km)',
            ROUND((SUM(route_distance_in_km + route_distance_out_km) + SUM(additional_in + aditional_out)), 2) AS 'Total Operated Km',
            SUM(staff_count) AS Staff
          
        FROM
            attendance_tbl
        WHERE
            (date BETWEEN '$startDate' AND '$endDate')
        GROUP BY 
            route_no
        ORDER BY 
            route_no ASC";

        } else {
            $sql = "SELECT
            route_no as 'Route Number',
            route as 'Route',
            SUM(turn_count) AS 'No of turns',
            SUM(additional_in + aditional_out) AS 'Additional Mileage(Km)',
            ROUND((SUM(route_distance_in_km + route_distance_out_km) + SUM(additional_in + aditional_out)), 2) AS 'Total Operated Km',
            SUM(staff_count) AS Staff
    FROM 
        attendance_tbl
    WHERE 
        (date BETWEEN '$startDate' AND '$endDate' AND route_no = '$routeNo')
    GROUP BY 
        route_no";
        }
        //echo $sql;
        $result = mysqli_query( $conn, $sql );

        if ( $result ) {
            while ( $row = mysqli_fetch_assoc( $result ) ) {
                $records[] = $row;

            }
        } else {
            // Handle the error more effectively, for example, log the error or send a response
            echo 'Error: ' . mysqli_error( $conn );
        }

        // Always close the database connection after usage
        mysqli_close( $conn );

        return $records;

    }
}