<?php

session_start();
if (!isset($_SESSION['DID'])) {
    header("Location: login.php");
    exit();
}

// Sanitize and validate GET parameters
$cid = intval($_GET['id']); // Ensure the crop ID is an integer
$did = intval($_GET['did']); // Ensure the dealer ID is an integer

// Include database connection
include("C:/xampp2/htdocs/khetbazar/partials/db_connect.php");

// Fetch crop details
$crop_det_sql = "SELECT `name`, `bid_expiry`, `base price` FROM `crop` WHERE `CID` = '$cid'";
$crop_det_result = mysqli_query($conn, $crop_det_sql);

if ($crop_det_result && mysqli_num_rows($crop_det_result) > 0) {
    $crop_det_row = mysqli_fetch_assoc($crop_det_result);
    $crop_name = htmlspecialchars($crop_det_row['name']); // Sanitize crop name
    $base_price = intval($crop_det_row['base price']); // Ensure base price is an integer
} else {
    die("Error: Crop details not found."); // Handle case where no crop details exist
}

// Fetch the most recent bid details
$crop_bid_sql = "SELECT `BID`, `active price`, `time_stamp` FROM `bid` WHERE `CID` = '$cid' 
                 ORDER BY `time_stamp` DESC LIMIT 1";
$crop_bid_result = mysqli_query($conn, $crop_bid_sql);

// Determine the current active price and prepare for a new bid
if (mysqli_num_rows($crop_bid_result) > 0) {
    $crop_bid_row = mysqli_fetch_assoc($crop_bid_result);
    $expiry_date = htmlspecialchars($crop_det_row['bid_expiry']); // Sanitize bid expiry
    $active_price = intval($crop_bid_row['active price']); // Ensure active price is an integer
    $temp_active_price = $active_price + 5; // Increment active price
} else {
    // No previous bid, set default values
    $expiry_date = htmlspecialchars($crop_det_row['bid_expiry']); // Sanitize bid expiry
    $active_price = $base_price; // Default active price
    $temp_active_price = $base_price + 5;
}

// Handle new bid submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bid_price = intval($_POST['bid_price'] ?? 0); // Get bid price from form input

    // Validate bid price
    if ($bid_price <= $active_price) {
        echo "<script>alert('Bid price must be higher than the current active price.');</script>";
        exit();
    }

    // Update the previous bid status to "over bided" only when a new bid is placed
    if (mysqli_num_rows($crop_bid_result) > 0) {
        $prev_bid_id = intval($crop_bid_row['BID']); // Sanitize bid ID
        $status_exp = 'over bided'; // Define the new status
        $update_prev_bid_sql = "UPDATE `bid` SET `status` = '$status_exp' WHERE `BID` = '$prev_bid_id'";
        if (!mysqli_query($conn, $update_prev_bid_sql)) {
            die("Error updating previous bid: " . mysqli_error($conn));
        }
    }

    // Insert the new bid into the database
    $insert_bid_sql = "INSERT INTO `bid` (`DID`, `CID`, `active price`, `status`, `expiry`, `time_stamp`) 
                       VALUES ('$did', '$cid', '$bid_price', 'active', '$expiry_date', current_timestamp())";
    if (!mysqli_query($conn, $insert_bid_sql)) {
        die("Error inserting bid: " . mysqli_error($conn));
    } else {
        echo "<script>alert('Bid placed successfully!');</script>";
        header("Location: dashboard1.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crop Details</title>

    <!-- Bootstrap and FontAwesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha384-oxRU9esBLAnMZtNo1QRR4AKjyX2obZ1c5Ln59/sIVxIaaSd1PphjiMZ" crossorigin="anonymous">
    <link rel="stylesheet" href="nav.css">
</head>

<body>
    <!-- Crop Details -->
    <?php include('nav.php'); ?>
    
    <div class="container my-4">
        <div class="row">
            <div class="col-md-6">
                <img src="images/garlic.jpg" alt="Crop Image" class="w-100 crop-image">
            </div>
            <div class="col-md-6">
                <h1><?php echo $crop_name; ?></h1>
                <div class="price">
                    ₹<?php echo $active_price; ?> (Base Price: ₹<?php echo $base_price; ?>)
                </div>
                <p class="text-muted">Bid ends on: <?php echo $expiry_date; ?></p>
                <button class="btn btn-md btn-primary" data-toggle="modal" data-target="#exampleModal">Bid now</button>
            </div>
        </div>
    </div>

    <!-- Bid Modal -->
    <center>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Bidding for crop <?php echo $crop_name; ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . "?id=$cid&did=$did"); ?>"
                        method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Amount:</label>
                                <div class="container row">
                                    <button type="button" class="btn btn-sm btn-primary col-2"
                                        onclick="decrease_bid()">-</button>
                                    <input type="text" class="form-control col-8" id="bid-amount" name="bid_price"
                                        readonly value="<?php echo $temp_active_price; ?>">
                                    <button type="button" class="btn btn-sm btn-primary col-2"
                                        onclick="increase_bid()">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Bid</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </center>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"></script>

    <!-- Bid Adjustment Scripts -->
    <script>
        var input = document.getElementById("bid-amount");

        function increase_bid() {
            var currentValue = parseInt(input.value);
            input.value = currentValue + 5;
        }

        function decrease_bid() {
            var inc_base_price = parseInt("<?php echo $temp_active_price; ?>");
            var currentValue = parseInt(input.value);
            if (currentValue <= inc_base_price) {
                input.value = inc_base_price;
            } else {
                input.value = currentValue - 5;
            }
        }
    </script>
</body>

</html>