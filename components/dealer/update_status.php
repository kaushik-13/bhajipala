<?php

include("C:/xampp2/htdocs/khetbazar/partials/db_connect.php");

    session_start();

    if(isset($_SESSION['cid'])){
        $cid=$_SESSION['cid'];
        $update_bid_sql="UPDATE `crop` SET `bid_status`='expired' WHERE `CID`='$cid';";
        $update_bid_sql_result=mysqli_query($conn,$update_bid_sql);
        if(!$update_bid_sql_result){
            echo"Problem inserting data";
        }
    }

?>