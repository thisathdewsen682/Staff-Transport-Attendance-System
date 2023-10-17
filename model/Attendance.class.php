<?php

class Attendance {
    //var $attendance_id;
    var $route_no;
    var $route;
    var $vehicle_no;
    var $staff_count;
    var $date;
    var $mark_in;
    var $mark_out;
    var $status;
    var $created_at;
    var $updated_at;

    function  Attendance(
        $route_no, $route, $vehicle_no, $staff_count, $date, $mark_in, $mark_out, $status, $created_at, $updated_at

    ) {
        //$this->attendance_id = $attendance_id;
        $this->route_no = $route_no;
        $this->route = $route;
        $this->vehicle_no = $vehicle_no;
        $this->staff_count = $staff_count;
        $this->date = $date;
        $this->mark_in = $mark_in;
        $this->mark_out = $mark_out;
        $this->status = $status;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
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
                            `staff_count` ,
                            `date` ,
                            `mark_in` ,
                            
                            `status` ,
                            `created_at` ,
                            `updated_at`
                            )
                            VALUES (
                            '". $obj->route_no ."', 
                            '". $obj->route ."', 
                            '". $obj->vehicle_no ."', 
                            '". $obj->staff_count ."', 
                            '". $obj->date ."', 
                            '". $obj->mark_in ."', 
                            '". $obj->status ."', 
                            '". $obj->created_at ."',
                            '". $obj->updated_at ."'
                            );";

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
            updated_at = '". $obj->updated_at ."' WHERE route_no = ". $rno .' AND mark_out IS NULL';

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

        $sql = 'SELECT * FROM   attendance_tbl WHERE attendance_id = '. $routeNo .'  ORDER BY created_at DESC';

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

        $sql = "UPDATE attendance_tbl SET vehicle_no = '".$att->vehicle_no."', staff_count = '".$att->staff_count."', mark_in = '".$att->mark_in."', mark_out = '".
        $att->mark_out."', updated_at = '".$att->updated_at ."'  WHERE attendance_id = '".$id."';";

        $result = mysqli_query( $conn, $sql );
        return $result;

    }

    function deletById( $conn, $att, $id ) {

        $sql = 'DELETE FROM attendance_tbl WHERE attendance_id = '.$id.'';

        $result = mysqli_query( $conn, $sql );

        return $result;
    }

}