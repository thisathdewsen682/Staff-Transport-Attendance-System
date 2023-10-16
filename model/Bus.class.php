<?php

class Bus {
    //var $id;
    var $vehicle_no;
    var $route_no;
    var $route_name;

    function  User(
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
    }

}

?>