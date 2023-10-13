<?php

class User {
    var $id;
    var $emp_no;
    var $user_name;
    var $password;
    var $is_admin;

    function  User(
        $id,
        $emp_no,
        $user_name,
        $password,
        $is_admin

    ) {
        $this->id = $id;
        $this->emp_no = $emp_no;
        $this->user_name = $user_name;
        $this->password = $password;
        $this->is_admin = $is_admin;

    }

    static function getUserByUnameAndPwd( $conn,  $uname, $pwd ) {

        $sql = "SELECT * FROM user  WHERE user_name ='".$uname."' AND pwd = '".$pwd."'; ";
        $result = mysqli_query( $conn, $sql );

        if ( mysqli_num_rows( $result ) == 1 ) {

            while( $row = mysqli_fetch_array( $result ) )
 {

                return  new User(
                    $row[ 'user_id' ],
                    $row[ 'emp_no' ],
                    $row[ 'user_name' ],
                    $row[ 'pwd' ],
                    $row[ 'is_admin' ]
                );
            }

        } else {
            return false;
        }
    }
}
?>