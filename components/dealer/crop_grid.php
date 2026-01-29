<?php
session_start();
if (!isset($_SESSION['DID'])) {
    header("Location: login.php");
    exit();
}

$DID = $_SESSION['DID'];

include("C:/xampp2/htdocs/khetbazar/partials/db_connect.php");

// Fetch active crops
$crop_sql = "SELECT * FROM `crop` WHERE `bid_status`='active';";
$crop_result = mysqli_query($conn, $crop_sql);

// Fetch dealer details
$dealer_sql = "SELECT * FROM `dealer` WHERE `DID`='$DID';";
$dealer_result = mysqli_query($conn, $dealer_sql);
$dealer_row = mysqli_fetch_assoc($dealer_result);

// Handle dealer profile image
$img = !empty($dealer_row['image']) ? $dealer_row['image'] : "images/profile.png";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap and FontAwesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <link rel="stylesheet" href="v-dashboard.css">
    <link rel="shortcut icon" href="images/icon.ico" type="image/x-icon">
    <title>BhajiPala</title>

    <style>
        .red-border {
            border: 2px solid red;
        }

        .green-border {
            border: 2px solid green;
            transition: border 0.3s ease-in-out;
        }
    </style>
</head>

<body>
    <div class="row">
        <div class="col-md-9 col-lg-10 main-content" id="main-content">
            <!-- Crop Suggestions -->
            <div class="bar">
                <div class="row">
                    <div class="col-sm">
                        Suggestions
                    </div>
                </div>
            </div>

            <section id="products">
                <div class="card-deck">
                    <div class="container">
                        <div class="row">
                            <?php
                            if ($crop_result && mysqli_num_rows($crop_result) > 0) {
                                while ($crop_row = mysqli_fetch_assoc($crop_result)) {
                                    echo "
                                    <div class='card col-md-3' style='padding-right:0px; padding-left:0px;'>
                                        <img class='card-img-top' src='images/onion.jpg' alt='Crop Image'>
                                        <div class='card-body'>
                                            <h5 class='card-title'>" . htmlspecialchars($crop_row['name']) . "</h5>
                                            <p class='card-text'>Base Price: ₹" . htmlspecialchars($crop_row['base price']) . "</p>
                                        </div>
                                        <div class='card-footer'>
                                            <button class='btn btn-sm btn-primary' onclick='loadCropDetails(" . $crop_row['CID'] . ", " . $DID . ")'>View Details</button>
                                        </div>
                                    </div>";
                                }
                            } else {
                                echo "<p class='text-danger'>No active crops found.</p>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </section>

            <br>
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
                            $holding_sql = "SELECT * FROM `crop` WHERE `CID` IN (SELECT `CID` FROM `bid` WHERE `DID`='$DID');";
                            $holding_sql_result = mysqli_query($conn, $holding_sql);

                            if ($holding_sql_result && mysqli_num_rows($holding_sql_result) > 0) {
                                echo "<div class='row'>";
                                while ($hold_row = mysqli_fetch_assoc($holding_sql_result)) {
                                    $bid_status_sql = "SELECT TRIM(`status`) AS `status` FROM `bid` WHERE `CID`='{$hold_row['CID']}' ORDER BY `BID` DESC LIMIT 1;";
                                    $bid_status_result = mysqli_query($conn, $bid_status_sql);
                                    $card_class = 'green-border';

                                    if ($bid_status_result && mysqli_num_rows($bid_status_result) > 0) {
                                        $bid_status_row = mysqli_fetch_assoc($bid_status_result);
                                        if (trim($bid_status_row['status']) === 'over bided') {
                                            $card_class = 'red-border';
                                        }
                                    }

                                    echo "
                                    <div class='card col-md-3 {$card_class}' style='padding-right:0px; padding-left:0px;'>
                                        <img class='card-img-top' src='images/onion.jpg' alt='Holding Image'>
                                        <div class='card-body'>
                                            <h5 class='card-title'>" . htmlspecialchars($hold_row['name']) . "</h5>
                                            <p class='card-text'>Base Price: ₹" . htmlspecialchars($hold_row['base price']) . "</p>
                                        </div>
                                        <div class='card-footer'>
                                            <button class='btn btn-sm btn-primary' onclick='loadCropDetails(" . $hold_row['CID'] . ", " . $DID . ")'>View Details</button>
                                        </div>
                                    </div>";
                                }
                                echo "</div>";
                            } else {
                                echo "
                                <div class='jumbotron jumbotron-fluid'>
                                    <div class='container'>
                                        <h1 class='display-4'>No Holdings Yet!</h1>
                                        <p class='lead'>You do not have any holdings yet.</p>
                                    </div>
                                </div>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- Footer -->
    

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <script>
        // Function to load crop details dynamically
        function loadCropDetails(cropId, dealerId) {
            $.ajax({
                url: 'crp_details1.php', // The target page to fetch data from
                method: 'GET',
                data: { id: cropId, did: dealerId },
                success: function (response) {
                    // Replace the content in #main-content with the fetched content
                    $('#main-content').html(response);
                },
                error: function () {
                    alert('Failed to load crop details. Please try again.');
                }
            });
        }
    </script>
</body>

</html>
