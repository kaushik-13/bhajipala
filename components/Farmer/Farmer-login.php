<?php
include("./db_connect.php");
session_start(); 

$message = ''; 

if(isset($_POST['sign'])) {
    $email = trim($_POST['email']);
    $pass = trim($_POST['pass']);
    if (empty($email) || empty($pass)) {
        $message = 'Email and password are required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Invalid email format';
    } else {
        $stmt = $conn->prepare("SELECT FID FROM farmer WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $pass);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['email'] = $email;
            $_SESSION['FID'] = $row['FID'];
            header("Location: farmer-dashboard.php");
            exit();
        } else {
            $message = 'Invalid email or password';
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha384-oxRU9esBLAnMZtNo1QRR4AKjyX2obZ1c5Ln59/sIVx+4pu5BspxIaaSd1PphjiMZ" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="shortcut icon" href="images/icon.ico" type="image/x-icon">
    <link rel="stylesheet" href="farmer-login.css">
    
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="images/icon.ico" alt="icon" style="height: 40px;">
            <span id="logo">BhajiPala.in</span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <form class="form-inline my-2 my-lg-0 mx-auto">
                <div class="col-auto">
                    <div class="input-group">
                        <input type="text" style="border-top-left-radius: 50px;border-bottom-left-radius: 50px;"
                            class="form-control" id="autoSizingInputGroup" placeholder="Search">
                        <div class="input-group-text"
                            style="border-top-right-radius: 50px;border-bottom-right-radius: 50px"><button
                                class="btn btn-sm" type="submit"><i class="fa fa-search"></i></button></div>
                    </div>
                </div>
            </form>
        </div>
        <div class="navbar-nav ml-auto">
            <a class="nav-item nav-link" href="homepage.html">Home</a>
            <a class="nav-item nav-link" href="#">About Us</a>
            <a class="nav-item nav-link" href="crop-details.html">Services</a>
           <!-- <a class="profile-icon" href="#"><img src="images/image2.png" alt="Profile Icon" class="profile-icon"></a> -->
            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="images/profile_icon.jpg" alt="Profile Icon" class="profile-icon">
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="F-register.html">Register as Farmer</a>
                    <a class="dropdown-item" href="V-register.html">Register as Vendor</a>
                    <a class="dropdown-item" href="Farmer-login.php">Login as Farmer</a>
                    <a class="dropdown-item" href="V-login.html">Login as Vendor</a>
                </div>
            </div>
        </div>
    </nav>

    <section id="hero">
        <div class="hero-container">
           <!-- <h1>Login as Farmer</h1> -->
           <div class="bar">
            <div class="row">
                <div class="col-sm">
                    Login as Farmer
                </div>
            </div>
        </div>
        <br>
            <?php if ($message): ?>
                <div class="alert alert-warning">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            <form action="<?php $_SERVER['PHP_SELF']?>" method="POST">
                    <div class="form-group col-md-12">
                        <label for="inputEmail4">Email:</label>
                        <input type="email" name="email" class="form-control" id="inputEmail4" placeholder="Email" status="required">
                    </div>
                    <br>
                    <div class="form-group col-md-12">
                        <label for="inputPassword4">Password:</label>
                        <input type="password" name="pass" class="form-control" id="inputPassword4" placeholder="Password" status="required">
                    </div>
                    <br><br>
                    <button type="submit" name="sign" class="btn btn-primary">Login</button>
            </form>
        </div>
    </section>

    <div class="footer">
        <p>&copy; 2025 BhajiPala - All Rights Reserved.</p>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
