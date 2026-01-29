<?php
// Start session
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

// Check if dealer details exist
if ($dealer_result && mysqli_num_rows($dealer_result) > 0) {
    $dealer_row = mysqli_fetch_assoc($dealer_result);
    // Check and set profile image
    $img = !empty($dealer_row['image']) && file_exists($dealer_row['image'])
        ? $dealer_row['image']
        : "images/profile.png";
} else {
    // Redirect if no dealer details are found
    header("Location: login.php");
    exit();
}
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

        .profile-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
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
            <form class="form-inline my-2 my-lg-0 mx-auto" method="GET" action="search_results.php">
                <div class="col-auto">
                    <div class="input-group">
                        <input type="text" class="form-control" id="search" name="query" placeholder="Search for a crop">
                        <div class="input-group-text">
                            <button class="btn btn-sm" type="submit"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="navbar-nav ml-auto">
            <a class="nav-item nav-link" href="homepage.php">Home</a>
            <a class="nav-item nav-link" href="#">About Us</a>
            <a class="nav-item nav-link" href="crop-details.html">Services</a>
            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                <img src="<?php echo htmlspecialchars($img); ?>" alt="Profile Icon" class="profile-icon">
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="F-register.html">Register as Farmer</a>
                    <a class="dropdown-item" href="registration.php">Register as Vendor</a>
                    <a class="dropdown-item" href="d_settings.html">Settings</a>
                    <a class="dropdown-item" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <div class="profile">
                    <img src="<?php echo $img; ?>" alt="Profile Photo">
                    <h3><?php echo $dealer_row['name']; ?></h3>
                    <p><?php echo $dealer_row['email']; ?></p>
                </div>
                <a href="#" style="border-radius: 50px;">Contact</a>
                <a href="#home" style="border-radius: 50px;">Home</a>
                <a href="#services" style="border-radius: 50px;">Services</a>
                <a href="d_settings.html" style="border-radius: 50px;">Settings</a>
                <a href="logout.php" class="logout" style="border-radius: 50px;">Logout</a>
            </div>

            <!-- Main Content Section -->
            <div class="col-md-9 col-lg-10 main-content" id="main-content">
                <p>Loading content, please wait...</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>@2025 BhajiPala - All Rights Reserved.</p>
    </div>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <script>
        // Function to load product grid dynamically
        function loadProductGrid() {
            $.ajax({
                url: 'crop_grid.php',
                method: 'GET',
                success: function (response) {
                    $('#main-content').html(response);
                },
                error: function () {
                    $('#main-content').html('<p class="text-danger">Failed to load product grid. Please try again later.</p>');
                }
            });
        }

        // Function to load crop details dynamically
        function loadCropDetails(cropId) {
            $.ajax({
                url: 'bidding_page.php',
                method: 'GET',
                data: { id: cropId },
                success: function (response) {
                    $('#main-content').html(response);
                },
                error: function () {
                    $('#main-content').html('<p class="text-danger">Failed to load crop details. Please try again later.</p>');
                }
            });
        }

        // Automatically load the product grid on page load
        $(document).ready(function () {
            loadProductGrid();
        });
    </script>
    <script>
    function loadCropGrid() {
        $.ajax({
            url: 'crop_grid.php', // The file to load dynamically
            method: 'GET',
            success: function (response) {
                $('#main-content').html(response); // Replace #main-content with the loaded grid
            },
            error: function () {
                alert('Failed to load crop grid. Please try again.');
            }
        });
    }

    // Automatically load the crop grid when the page loads
    $(document).ready(function () {
        loadCropGrid(); // Load the crop grid by default
    });
</script>
<!-- <script>
    // Function to load the crop grid dynamically
    function loadCropGrid() {
        $.ajax({
            url: 'crop_grid.php', // Fetch the crop grid content
            method: 'GET',
            success: function (response) {
                $('#main-content').html(response); // Replace #main-content with the crop grid
            },
            error: function () {
                alert('Failed to load crop grid. Please try again.');
            }
        });
    }
</script> -->


</body>

</html>
