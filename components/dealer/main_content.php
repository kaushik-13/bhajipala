<?php

session_start();
if (!isset($_SESSION['DID'])) {
    header("Location: login.php");
    exit();
}

$DID = $_SESSION['DID'];
include("C:/xampp2/htdocs/khetbazar/partials/db_connect.php");
$crop_sql = "SELECT * FROM `crop`;";
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
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link rel="stylesheet" href="v-dashboard.css">

    <title>Hello, world!</title>
</head>

<body>

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
                <div class="card">
                    <img class="card-img-top" src="images/onion.jpg" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Onion</h5>
                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to
                            additional content. This content is a little bit longer.</p>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">Rating</small>
                    </div>
                </div>
                <div class="card">
                    <img class="card-img-top" src="images/tomato.jpg" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Tomato</h5>
                        <p class="card-text">This card has supporting text below as a natural lead-in to additional
                            content.</p>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">Rating</small>
                    </div>
                </div>
                <div class="card">
                    <img class="card-img-top" src="images/potato.jpg" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Potato</h5>
                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to
                            additional content. This card has even longer content than the first to show that equal
                            height action.</p>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">Rating</small>
                    </div>
                </div>
                <div class="card">
                    <img class="card-img-top" src="images/rice.jpeg" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Rice</h5>
                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to
                            additional content. This content is a little bit longer.</p>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">Rating</small>
                    </div>
                </div>
            </div>
        </div>
    </section><br>



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
        <!-- <div class="container"> -->
        <div class="card-deck">
            <!-- --------------------------------------------------------- -->
            <?php

            if ($crop_result) {
                while ($crop_row = mysqli_fetch_assoc($crop_result)) {
                    echo "<div class='card'>
                                    <img class='card-img-top' src='https://media.istockphoto.com/id/1279529996/photo/fresh-peanuts-plants-with-roots.jpg?s=612x612&w=0&k=20&c=IUocTYpKwQalpwvrHd5WIdzKXZ4A5OXYgDSIxa5wx98=' alt='Card image cap'>
                                    <div class='card-body'>
                                        <h5 class='card-title'>{$crop_row['name']}</h5>
                                        <p class='card-text'>Base price - {$crop_row['base price']}</p>
                                    </div>
                                    <div class='card-footer'>
                                        <a href='crp_details.php?id={$crop_row['CID']}' style='color:white;text-decoration:none;'><button class='btn btn-sm btn-primary'>View details</button></a>
                                    </div>
                                </div>";
                }
            }

            ?>

            <!-- ------------------------------------ -->
        </div>
        <!-- </div> -->
    </section><br>


    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
</body>

</html>