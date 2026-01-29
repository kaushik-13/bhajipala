<?php
$cid = intval($_GET['id']); // Ensure the crop ID is an integer
$did = intval($_GET['did']); // Ensure the dealer ID is an integer

include("C:/xampp2/htdocs/khetbazar/partials/db_connect.php");

// Fetch crop details
$crop_det_sql = "SELECT * FROM `crop` WHERE `CID`='$cid'";
$crop_det_result = mysqli_query($conn, $crop_det_sql);

if ($crop_det_result && mysqli_num_rows($crop_det_result) > 0) {
    $crop_det_row = mysqli_fetch_assoc($crop_det_result);
    $expiry_date = $crop_det_row['bid_expiry'];
    $base_price = $crop_det_row['base price'];
} else {
    die("Crop details not found.");
}

// Fetch the most recent bid details
$crop_bid_sql = "SELECT * FROM `bid` WHERE `CID`='$cid' ORDER BY `time_stamp` DESC LIMIT 1 FOR UPDATE";
$crop_bid_result = mysqli_query($conn, $crop_bid_sql);

if ($crop_bid_result && mysqli_num_rows($crop_bid_result) > 0) {
    $crop_bid_row = mysqli_fetch_assoc($crop_bid_result);
    $active_price = $crop_bid_row['active price'];
    $temp_active_price = (int) $active_price + 5;
} else {
    $active_price = $base_price;
    $temp_active_price = (int) $base_price + 5;
}
?>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Crop Details</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    integrity="sha384-oxRU9esBLAnMZtNo1QRR4AKjyX2obZ1c5Ln59/sIVxIaaSd1PphjiMZ" crossorigin="anonymous">

<link rel="stylesheet" href="nav.css">

<div class="container my-4">
    <div class="row">
        <div class="col-md-6">
            <img src="images/garlic.jpg" alt="Crop Image" class="w-100 crop-image">
        </div>
        <div class="col-md-6">
            <h1><?php echo htmlspecialchars($crop_det_row['name']); ?></h1>
            <div class="price">₹<?php echo $active_price; ?> (Base Price: ₹<?php echo $base_price; ?>)</div>
            <p class="text-muted">Bid ends on: <?php echo htmlspecialchars($expiry_date); ?></p>
            <button class="btn btn-md btn-primary" data-toggle="modal" data-target="#exampleModal">Bid now</button>
            <!-- Back to Grid Button -->
            <button class="btn btn-secondary mt-3" onclick="loadCropGrid()" style="vertical-align:bottom;">Back to Crop
                Grid</button>
        </div>
    </div>
</div>

<!-- Modal -->
<center>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Bidding for crop
                        <?php echo htmlspecialchars($crop_det_row['name']); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php $_PHP_SELF; ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Amount:</label>
                            <div class="container row">
                                <button type="button" class="btn btn-sm btn-primary col-2" onclick="decrease_bid()">-
                                </button>
                                <input type="text" class="form-control col-8" id="bid-amount" name="bid_price" readonly
                                    value="<?php echo $temp_active_price; ?>">
                                <button type="button" class="btn btn-sm btn-primary col-2" onclick="increase_bid()">+
                                </button>
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

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"></script>

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
<script>
    // Function to dynamically load the crop grid
    function loadCropGrid() {
        $.ajax({
            url: 'crop_grid.php', // Fetch crop grid content
            method: 'GET',
            success: function (response) {
                $('#main-content').html(response); // Replace #main-content with the crop grid
            },
            error: function () {
                alert('Failed to load crop grid. Please try again.');
            }
        });
    }
</script>
