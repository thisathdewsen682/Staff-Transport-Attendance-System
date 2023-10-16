<?php

class Bus {
    //var $id;
    var $vehicle_no;
    var $route_no;
    var $route_name;

    function  Bus(
        //$id,
        $vehicle_no,
        $route_no,
        $route_name

    ) {
        //$this->id = $id;
        $this->vehicle_no = $vehicle_no;
        $this->route_no = $route_no;
        $this->route_name = $route_name;

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
                        `route`
                        )
                        VALUES (
                         '". $obj->vehicle_no ."', 
                         '". $obj->route_no ."', 
                         '". $obj->route_name ."'   
                        );";

            $result = mysqli_query( $conn, $sql );

            return $result;
        }
    }

}

?>