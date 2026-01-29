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

    <link rel="stylesheet" href="nav.css">

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
                            class="form-control" id="autoSizingInputGroup" placeholder="Search">
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
                    <img src="images/profile.png" alt="Profile Icon" class="profile-icon">
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="F-register.html">Register as Farmer</a>
                    <a class="dropdown-item" href="registration.php">Register as Vendor</a>
                    <a class="dropdown-item" href="Farmer-login.html">login as farmer</a>
                    <a class="dropdown-item" href="logout.php">login as dealer</a>
                </div>
            </div>
        </div>
    </nav>
</body>