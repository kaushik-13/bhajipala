<?php
include("./db_connect.php");
session_start();
$response = array();
if (isset($_POST['sign'])) {
    $crop = $_POST['crop'];
    $category = $_POST['Category'];
    $harvest = $_POST['harvest'];
    $plantation_date = $_POST['date'];
    $grade = $_POST['grade'];
    $description = $_POST['description'];
    $base_price = $_POST['base-price'];
    $bid_interval = $_POST['bid'];
    $status = "Active";
    $uploadedcropPaths = "";
    $FID = $_SESSION['FID'];

    if (isset($_FILES['crop_image'])) {
        $crop_dir = "C:/xampp/htdocs/Farmer/crop_images/";
        $crop_file = $_FILES['crop_image'];

        $cropNewName = $FID.'_name'.$crop. '_crop.' . pathinfo($crop_file['name'], PATHINFO_EXTENSION);

        $cropUploadFile = $crop_dir . basename($cropNewName);

        if (move_uploaded_file($crop_file['tmp_name'], $cropUploadFile)) {
            $uploadedcropPaths = $cropUploadFile;
        } else {
            $response['error'] = 'Failed to upload file.';
            echo json_encode($response);
            exit();
        }
    }

    $crop_location = $uploadedcropPaths;
    $sql = "INSERT INTO `crop` (`CID`, `FID`, `name`, `category`, `status`, `harvest`, `plantation date`, `grade`, `image`, `descr`, `base price`, `bid_interval`) 
            VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssss", $FID, $crop, $category, $status, $harvest, $plantation_date, $grade, $crop_location, $description, $base_price, $bid_interval);

    if ($stmt->execute()) {
        $crop_id = $stmt->insert_id;
        header("Location: farmer-dashboard.php");
        exit();
    } else {
        $response['error'] = "Error: " . $stmt->error;
        echo json_encode($response);
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Crop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha384-oxRU9esBLAnMZtNo1QRR4AKjyX2obZ1c5Ln59/sIVx+4pu5BspxIaaSd1PphjiMZ" crossorigin="anonymous">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="shortcut icon" href="images/icon.ico" type="image/x-icon">

    <link rel="stylesheet" href="F-register.css">
    
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
                    <img src="images/profile_icon.png" alt="Profile Icon" class="profile-icon">
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
           <!-- <h1>Upload crop</h1> -->
           <div class="bar">
            <div class="row">
                <div class="col-sm">
                    Upload Crop
                </div>
            </div>
        </div>
        <br>
            <form action="<?php  $_PHP_SELF ?>" method="POST" enctype="multipart/form-data" id="cropForm">

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="crop">Crop Name:</label>
                        <input type="text" name="crop" class="form-control" id="crop" placeholder="crop" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="Category">Category:</label>
                        <select name="Category" class="form-control" id="Category" required>
                            <option value="">Select Category</option>
                            <option value="Fruits">Fruits</option>
                            <option value="Vegetables">Vegetables</option>
                            <option value="Grains">Grains</option>
                            <option value="Seeds">Seeds</option>
                        </select>
                    </div>

                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="harvest">Plantation Date:</label>
                        <input type="date" name="date" class="form-control" id="harvest" placeholder="Harvest" required>
                    </div>
                </div>


                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="date">Harvest Date:</label>
                            <input type="date" name="harvest" class="form-control" id="date" placeholder="Plantation Date" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="grade">Grade:</label>
                            <select name="grade" class="form-control" id="grade" required>
                                <option value="">Select Category</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="description">Description:</label>
                            <input type="text" name="description" class="form-control" id="description" placeholder="description" required>
                        </div>
                    </div><br>
                <center>
                    <div class="form-group col-md-6">
                        <label for="image">Upload photo:</label><br>
                        <input type="file" id="image" name="crop_image" accept="image/*" required>
                    </div><br>
                </center>

                <div class="form-row">
                   
                    <div class="form-group col-md-6">
                        <label for="base-price">Base price:</label>
                        <input type="text" name="base-price" class="form-control" id="base-price" placeholder="Base price" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="bid">Bid Interval</label><br>
                        <select name="bid" class="form-control" id="bid" required>
                            <option value="">Select Category</option>
                            <option value="1">1 Day</option>
                            <option value="2">2 Day</option>
                            <option value="3">3 Day</option>
                            <option value="4">4 Day</option>
                            <option value="5">5 Day</option>
                        </select>
                    </div>
                    
                </div>
            <button type="submit" name="sign" class="btn btn-primary">Submit</button>
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