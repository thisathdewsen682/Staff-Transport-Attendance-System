<?php

class Bus {
    //var $id;
    var $vehicle_no;
    var $route_no;
    var $route_name;
    var $type;
    var $route_distance1;
    var $route_distance2;

    function  Bus(
        //$id,
        $vehicle_no,
        $route_no,
        $route_name,
        $type,
        $route_distance1,
        $route_distance2

    ) {
        //$this->id = $id;
        $this->vehicle_no = $vehicle_no;
        $this->route_no = $route_no;
        $this->route_name = $route_name;
        $this->type = $type;
        $this->route_distance1 = $route_distance1;
        $this->route_distance2 = $route_distance2;

    }

    function insertNewRoute ( $conn, $obj, $rno ) {
        //check route no already exist

        $checksql = 'SELECT * FROM vehicle_detail WHERE  route_no = '.$rno.'';
        $checkStatus = mysqli_query( $conn, $checksql );

        if ( mysqli_num_rows( $checkStatus ) > 0 ) {
            echo 'This Route No Already Added';
        } else {
            $sql = "INSERT INTO `vehicle_detail` (
                        `vehicle_no` ,
                        `route_no` ,
                        `route`,
                        `type`,
                        `route_distance1`,
                        `route_distance2`
                        )
                        VALUES (
                         '". $obj->vehicle_no ."', 
                         '". $obj->route_no ."', 
                         '". $obj->route_name ."',   
                         '". $obj->type ."',   
                         '". $obj->route_distance1 ."',   
                         '". $obj->route_distance2 ."'   
                        );";

            $result = mysqli_query( $conn, $sql );

            return $result;
        }
    }

    static function viewAll( $conn ) {

        $sql = 'SELECT * FROM vehicle_detail';
        $result = mysqli_query( $conn, $sql );

        if ( mysqli_num_rows( $result ) > 0 ) {
            while( $row = mysqli_fetch_assoc( $result ) ) {
                echo "<tr class='table-info text-center'  class = 'editLink' id = 'edit'>
                <td>".$row[ 'vehicle_no' ]."</td>
                <td>".$row[ 'route_no' ]."</td>
                <td>".$row[ 'route' ]."</td>
                <td>".$row[ 'type' ]."</td>
                <td>".$row[ 'route_distance1' ]."</td>
                <td>".$row[ 'route_distance2' ]."</td>
                <td><a href = '' class = 'edit btn btn-success' data-id='{$row['id']}'>Edit</td>
                <td><a href = '' class = 'delete btn btn-danger' data-id='{$row['id']}'>Delete</td></td>
                </tr>";
            }
        }

    }

    function viewEditFormByID( $conn, $id ) {

        $sql = 'SELECT * FROM vehicle_detail WHERE id = "'.$id.'"';

        $result = mysqli_query( $conn, $sql );
        if ( $result ) {

        } else {
            mysqli_connect_error( $conn, $result );
        }
        return $result;

    }

    function updateBusById( $conn, $id, $obj ) {

        $sql = "UPDATE vehicle_detail 
        SET 
            vehicle_no = '".$obj->vehicle_no."',
            route_no = '".$obj->route_no."',
            route = '".$obj->route_name."',
            type = '".$obj->type."',
            route_distance1 = '".$obj->route_distance1."',
            route_distance2 = '".$obj->route_distance2."'
        WHERE id = $id";

        $result = mysqli_query( $conn, $sql );
        if ( $result ) {
            echo 'Details Updated Succesfully';
        } else {
            echo mysqli_error( $conn, $sql );
            echo 'Something Wrong Details Update Fail';
        }
        return $result;

    }

    static function deleteBusById( $conn, $id ) {

        $sql = 'DELETE FROM vehicle_detail WHERE id = "'.$id.'"';

        $result = mysqli_query( $conn, $sql );

        if ( $result ) {
            echo 'Deleted Succesfully';
        } else {
            echo mysqli_error( $conn, $sql );
            echo 'Something Wrong';
        }

        return $result;
    }

}

?>