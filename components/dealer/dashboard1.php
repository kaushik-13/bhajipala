<?php
ob_start();

session_start();
if (!isset($_SESSION['DID'])) {
    header("Location: login.php");
    exit();
}

$DID = $_SESSION['DID'];

include("C:/xampp2/htdocs/khetbazar/partials/db_connect.php");
$crop_sql = "SELECT * FROM `crop`WHERE `bid_status`='active';";
$crop_result = mysqli_query($conn, $crop_sql);

$dealer_sql = "SELECT * FROM `dealer` WHERE `DID`='$DID';";
$dealer_result = mysqli_query($conn, $dealer_sql);
$dealer_row = mysqli_fetch_assoc($dealer_result);

$img = "";
if ($dealer_row['image'] == "") {
    $img = "images/profile.png";
} else {
    $img = str_replace("C:/xampp2/htdocs", "", $dealer_row['image']);
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha384-oxRU9esBLAnMZtNo1QRR4AKjyX2obZ1c5Ln59/sIVx+4pu5BspxIaaSd1PphjiMZ" crossorigin="anonymous">

    <link rel="stylesheet" href="v-dashboard.css">

    <link rel="shortcut icon" href="images/icon.ico" type="image/x-icon">

    <title>BhajiPala</title>

    <style>
        .green-border {
            /* border: 2px solid green; */
            box-shadow: 0px 0px 4px 4px rgba(0, 128, 0, 0.5);
            /* Green shadow with transparency */
            transition: border 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .red-border {
            /* border: 2px solid red; */
            box-shadow: 0px 0px 4px 4px rgba(255, 0, 0, 0.5);
            /* Red shadow with transparency */
            transition: border 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }
    </style>


</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="images/icon.png" alt="icon" style="height: 40px;">
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
                            class="form-control" id="search" placeholder="Search for a crop">
                        <div class="input-group-text"
                            style="border-top-right-radius: 50px;border-bottom-right-radius: 50px"><button
                                class="btn btn-sm" type="submit"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="navbar-nav ml-auto">
            <a class="nav-item nav-link" href="homepage.php">Home</a>
            <a class="nav-item nav-link" href="#">About Us</a>
            <a class="nav-item nav-link" href="crop-details.html">Services</a>
            <!--<a class="profile-icon" href="#"><img src="images/profile_icon.png" alt="Profile Icon" class="profile-icon"></a>-->
            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <img src="<?php echo $img; ?>" alt="Profile Icon" class="profile-icon">
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" style="margin-left: 0px; margin-right: 0px;"
                        href="F-register.html">Register as Farmer</a>
                    <a class="dropdown-item" style="margin-left: 0px; margin-right: 0px;"
                        href="registration.php">Register as Vendor</a>
                    <a class="dropdown-item" style="margin-left: 0px; margin-right: 0px;"
                        href="d_settings.html">settings</a>
                    <a class="dropdown-item" style="margin-left: 0px; margin-right: 0px;" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">

            <div class="col-md-3 col-lg-2 sidebar">
                <div class="profile">
                    <img src="<?php echo $img; ?>" alt="Profile Photo">
                    <h3><?php echo $dealer_row['name']; ?></h3>
                    <p><?php echo $dealer_row['email']; ?></p>
                </div>
                <a style="border-radius: 50px;">Contact</a>
                <a href="#home" style="border-radius: 50px;">Home</a>
                <a href="#services" style="border-radius: 50px;">Services</a>
                <a href="#" style="border-radius: 50px;">Settings</a>
                <a href="logout.php" class="logout" style="border-radius: 50px;">Logout</a>
            </div>


            <div class="col-md-9 col-lg-10 main-content" id="main-content">
                <!-- main content -->
                <div class="col-md-9 col-lg-10 main-content">
                    <div class="bar">
                        <div class="row">
                            <div class="col-sm">
                                Suggestions
                            </div>
                        </div>
                    </div>
                </div>

                <section id="products">
                    <div class="card-deck">
                        <div class="container">
                            <div class="row">
                                <?php
                                if ($crop_result) {
                                    while ($crop_row = mysqli_fetch_assoc($crop_result)) {
                                        echo "<div class='card col-md-3' style='padding-right:0px; padding-left:0px;'>
                                    <img class='card-img-top' src='https://media.istockphoto.com/id/1279529996/photo/fresh-peanuts-plants-with-roots.jpg?s=612x612&w=0&k=20&c=IUocTYpKwQalpwvrHd5WIdzKXZ4A5OXYgDSIxa5wx98=' alt='Card image cap'>
                                    <div class='card-body'>
                                        <h5 class='card-title'>{$crop_row['name']}</h5>
                                        <p class='card-text'>Base price - {$crop_row['base price']}</p>
                                    </div>
                                    <div class='card-footer'>
                                        <a href='crp_details.php?id={$crop_row['CID']}&did={$DID}' style='color:white;text-decoration:none;'><button class='btn btn-sm btn-primary'>View details</button></a>
                                    </div>
                                </div>";
                                    }
                                }

                                ?>

                            </div>
                        </div>

                    </div>
                </section><br>
                <div class="bar">
                    <div class="row">
                        <div class="col-sm">
                            Current Holdings
                        </div>
                    </div>
                </div>


                <section id="products">
                    <div class="container">
                        <div class="card-deck">

                            <div class="container">

                                <?php

                                $holding_sql = "SELECT * FROM `crop` WHERE `bid_status`='active' AND `CID` IN (SELECT `CID` FROM `bid` WHERE `DID`='$DID');";
                                $holding_sql_result = mysqli_query($conn, $holding_sql);

                                if ($holding_sql_result) {
                                    if (mysqli_num_rows($holding_sql_result) > 0) {
                                        echo "<div class='row'>";

                                        while ($hold_row = mysqli_fetch_assoc($holding_sql_result)) {
                                            // Use your working query to get the bid status
                                            $bid_status_sql = "SELECT `status` FROM `bid` WHERE `CID` = '{$hold_row['CID']}' AND `DID`='$DID' ORDER BY `BID` DESC LIMIT 1;";
                                            $bid_status_result = mysqli_query($conn, $bid_status_sql);

                                            // Default border class
                                            $card_class = 'green-border'; // Default to green-border
                                
                                            if ($bid_status_result && mysqli_num_rows($bid_status_result) > 0) {
                                                $bid_status_row = mysqli_fetch_assoc($bid_status_result);

                                                if (strcasecmp(trim($bid_status_row['status']), 'over bided') === 0) {
                                                    $card_class = 'red-border';
                                                }
                                            } else {
                                                echo "<p>Debug: No bid status found for CID: {$hold_row['CID']}</p>";
                                            }

                                            // Render the crop card with appropriate border class
                                            echo "<div class='card col-md-3 $card_class' style='padding-right:0px; padding-left:0px;'>
                                                    <img class='card-img-top' src='images/onion.jpg' alt='Crop image'>
                                                    <div class='card-body'>
                                                    <h5 class='card-title'>" . htmlspecialchars($hold_row['name']) . "</h5>
                                                    <p class='card-text'>Base price - ₹" . htmlspecialchars($hold_row['base price']) . "</p>
                                                </div> 
                                                <div class='card-footer'>
                                                    <a href='crp_details.php?id=" . htmlspecialchars($hold_row['CID']) . "&did=$DID' style='color:white;text-decoration:none;'>
                                                        <button class='btn btn-sm btn-primary'>View details</button>
                                                    </a>
                                                </div>
                                                </div>";
                                        }

                                        echo "</div>";
                                    } else {
                                        echo "<div class='jumbotron jumbotron-fluid'>
                                                <div class='container'>
                                                    <h1 class='display-4'>No holdings yet !!!</h1>
                                                    <p class='lead'>You do not have holdings yet.</p>
                                                </div>
                                            </div>";
                                    }
                                } else {
                                    die("Error fetching crop holdings: " . mysqli_error($conn));
                                }
                                ?>






                            </div>



                        </div>
                    </div>
                </section><br>





            </div>
        </div>
    </div>




    <div class="footer">
        <p>@2025 BhajiPala - All Rights Reserved.</p>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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
<?php ob_end_flush(); ?>