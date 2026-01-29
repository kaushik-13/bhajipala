<?php

include("C:/xampp2/htdocs/khetbazar/partials/db_connect.php");
$correct_cred = -1;

session_start();

if(isset($_SESSION['DID'])){
    header("Location: dashboard1.php");
    exit();
}
else{

    if (isset($_POST['sign'])) {
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $sql = "SELECT `email`,`password`, `DID` FROM `dealer` WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
        
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    if (password_verify($pass, $row['password'])) {
                        
                        $correct_cred = 1;
                        session_start();
                        $_SESSION['DID'] = $row['DID'];
                        $_SESSION['d_email']=$email;
                        
                        header("Location: dashboard1.php");
                        exit();
                    } else {
                        $correct_cred = 0;
                    }
                }
            }
            else{
                $correct_cred=2;
            }
        }
    }
}
    
    ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha384-oxRU9esBLAnMZtNo1QRR4AKjyX2obZ1c5Ln59/sIVx+4pu5BspxIaaSd1PphjiMZ" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="shortcut icon" href="images/icon.ico" type="image/x-icon">

    <link rel="stylesheet" href="V-login.css">

</head>

<body>

    <?php
    include("./nav.php");
    ?>



    <section id="hero">
        <div class="hero-container">
            <?php
            if ($correct_cred == 0) {
                echo "
                <div class='alert alert-danger' role='alert'>
                    please enter correct credentials!!!
                </div>";
            }
            if($correct_cred==2){
                echo "
                <div class='alert alert-danger' role='alert'>
                   User does not exist !!!
                </div>";
            }
            ?>
            <!-- <h1>Login as Vendor</h1> -->
            <div class="bar">
                <div class="row">
                    <div class="col-sm">
                        Login as Vendor
                    </div>
                </div>
            </div>
            <br>
            <form action="<?php $_PHP_SELF ?>" method="post">
                <div class="form-group col-md-12">
                    <label for="inputEmail4">Email:</label>
                    <input type="email" name="email" class="form-control" id="inputEmail4" placeholder="Email" required>
                </div>
                <br>
                <div class="form-group col-md-12">
                    <label for="inputPassword4">Password:</label>
                    <input type="password" name="pass" class="form-control" id="inputPassword4" placeholder="Password"
                        required>
                </div>
                <small id="emailHelp" class="form-text"><a href="forgot_pass.php" style="text-decoration: none;color:white;">forgot password??</a></small>
                <br>
                <button type="submit" name="sign" class="btn btn-primary">Login</button>
            </form>
        </div>
    </section>

    <div class="footer">
        <p>&copy; 2025 BhajiPala - All Rights Reserved.</p>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>

</html>