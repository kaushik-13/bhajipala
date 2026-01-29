<?php
include("./db_connect.php");
session_start();

if(isset($_POST['sign']))
{
   $email =$_POST['email'];
   $city = $_POST['city'];
   $phone = $_POST['phone'];
   $aadhar =$_POST['aadhar-no'];
   $name = $_POST['name'];
   $pass = $_POST['pass'];
   $add1 = $_POST['add1'];
   $gut = $_POST['gut'];
   $state =$_POST['state'];
   $code = $_POST['code'];
   $aadhar_p =$_POST['aadhar'];
   $photo = $_POST['photo'];
   $acc_no =$_POST['acc_no'];
   $ifsc =$_POST['IFSC'];
   $acc_holder_name =$_POST['acc_holder_name'];
   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
   {
      echo "<script>alert('Invalid email format!')</script>";
   }  
   else 
   {
      $sql = "INSERT INTO `farmer` (`FID`, `name`, `image`, `phone`, `email`, `password`, `status`, `location`, `gut_no`, `state`, `adhar no`, `date`) VALUES (NULL, '$name', '$aadhar_p', '$phone', '$email', '$pass', '', '$add1', '$gut', '$state', '$aadhar', current_timestamp());";
      $result1 = mysqli_query($conn, $sql);
      
      if($result1) 
      {
         $farmer_id = mysqli_insert_id($conn);

         $_SESSION['FID'] = $farmer_id;
         
         $sql2 = "INSERT INTO `bank_details` (`B_ID`, `FID`, `acc_no`, `IFSC`, `acc_holder_name`) VALUES (NULL, '$farmer_id', '$acc_no', '$ifsc', '$acc_holder_name');";
         $result2 = mysqli_query($conn, $sql2);

         if($result2)  
         {
            echo "<script>
            alert('You are registered successfully!');
            setTimeout(function() {
               window.location.href = 'homepage.html';
            }, 100); 
         </script>";
         } else 
         {
            echo "Error inserting record in bank_details<br>" . mysqli_error($conn);
         }
      }
      else 
      {
         echo "Error inserting record in farmer<br>" . mysqli_error($conn);
      }
   }
}
?>
