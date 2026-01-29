<?php

    $conn=mysqli_connect("localhost","root","","khetbazar");

    if(!$conn){
        echo"Connection failed";
    }