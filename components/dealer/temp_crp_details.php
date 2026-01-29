<?php
$cid = $_GET['id'];
$did = $_GET['did'];

include("C:/xampp2/htdocs/khetbazar/partials/db_connect.php");

$crop_det_sql = "SELECT * FROM `crop` WHERE `CID`='$cid';";
$crop_bid_sql = "SELECT * FROM `bid` WHERE `CID`='$cid' ORDER BY `time_stamp` DESC LIMIT 1;";

$base_price = "";
$active_price = "";
$expiry_date = "";
$status_exp = "over bided";

$temp_active_price = 0;

$crop_det_result = mysqli_query($conn, $crop_det_sql);
$crop_bid_result = mysqli_query($conn, $crop_bid_sql);
$crop_bid_row =[];
$crop_det_row=[];
// Check if there's a previous bid
$crop_det_row=mysqli_fetch_assoc($crop_det_result);
if (mysqli_num_rows($crop_bid_result) > 0) {
    $crop_bid_row = mysqli_fetch_assoc($crop_bid_result);
    

    $expiry_date = $crop_det_row['bid_expiry'];
    $base_price = $crop_det_row['base price'];
    if (!empty($crop_bid_row['active price'])) {
        $active_price = $crop_bid_row['active price'];
        $temp_active_price = (int) $active_price + 5;
    } else {
        $active_price = $base_price;
        $temp_active_price = (int) $active_price + 5;
    }
    
    // Update the previous bid status to "over bided"
    $prev_bid_id = $crop_bid_row['BID'];
    $update_prev_bid_sql = "UPDATE `bid` SET `status` = '$status_exp' WHERE `BID` = '$prev_bid_id'";
    mysqli_query($conn, $update_prev_bid_sql);
} else {
    // No previous bid, set default values
    $expiry_date = $crop_det_row['bid_expiry'];
    $base_price = $crop_det_row['base price'];
    $temp_active_price = (int) $base_price + 5;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bid_price = $_POST['bid_price'];

    $place_bid_sql = "INSERT INTO `bid`(`DID`, `CID`, `active price`, `status`, `expiry`, `time_stamp`) VALUES ('$did', '$cid', '$bid_price', 'active', '$expiry_date', current_timestamp())";
    $place_bid_result = mysqli_query($conn, $place_bid_sql);

    if (!$place_bid_result) {
        echo "<script>alert('Problem inserting bid !!')</script>";
    } else {
        header("Location: dashboard1.php");
        exit();
    }
}


?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>

<body>

    <center>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Bidding for crop <?php echo $cid; ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?php $_PHP_SELF; ?>" method="post">
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

    <ul class="list-group">
        <li class="list-group-item"><?php echo "Dealer id is " . $did; ?></li>
        <li class="list-group-item"><?php echo "Crop id is " . $cid; ?></li>
        <li class="list-group-item"><?php echo "base price is " . $base_price; ?></li>
        <li class="list-group-item"><?php echo "Active price is  " . $active_price; ?></li>
        <li class="list-group-item">
            <button class="btn btn-md btn-primary" data-toggle="modal" data-target="#exampleModal">Bid now</button>
        </li>
    </ul>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>

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
