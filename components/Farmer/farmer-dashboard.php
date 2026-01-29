<?php
include("./db_connect.php");
session_start();
$FID = $_SESSION['FID'];
$sql = "SELECT * FROM `farmer` WHERE `FID`=$FID";
$result = mysqli_query($conn, $sql);
$result_row = mysqli_fetch_assoc($result);
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
  <link rel="stylesheet" href="f-dashboard.css">
  <link rel="shortcut icon" href="images/icon.ico" type="image/x-icon">
  <title>BhajiPala</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg">
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
            <input type="text" style="border-top-left-radius: 50px; border-bottom-left-radius: 50px;"
              class="form-control" id="autoSizingInputGroup" placeholder="Search">
            <div class="input-group-text" style="border-top-right-radius: 50px; border-bottom-right-radius: 50px">
              <button class="btn btn-sm" type="submit"><i class="fa fa-search"></i></button>
            </div>
          </div>
        </div>
      </form>
    </div>
    <div class="navbar-nav ml-auto">
      <a class="nav-item nav-link" href="homepage.html">Home</a>
      <a class="nav-item nav-link" href="#">About Us</a>
      <a class="nav-item nav-link" href="crop-details.html">Services</a>
      <div class="dropdown">
        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
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
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3 col-lg-2 sidebar">
        <div class="profile">
          <img src="images/profile_icon.jpg" alt="Profile Photo">
          <h3><?php echo $result_row['name'] ?></h3>
          <p><?php echo $result_row['email'] ?></p>
        </div>
        <a href="#">Contact</a>
        <a href="#">Update Profile photo</a>
        <a href="#">Update Password</a>
        <a href="#">Advanced Settings</a>
        <a href="Farmer-login.php" class="logout">Logout</a>
      </div>
      <div class="col-md-9 col-lg-10 main-content">
        <div class="bar">
          <div class="row">
            <div class="col-sm text-center">Active Crops</div>
          </div>
        </div>
        <section id="products">
          <div class="container-fluid">
            <div class="row">
              <?php
              echo "<div class='col-md-6 col-lg-3'>
              <div class='card mt-3'>
                <div class='card-body text-center'>
                  <img src='images/add_icon.jpg' alt='Initial Crop Image' style='width: 200px; height: 200px; display: block; margin: 0 auto 10px;'>
                  <a href='upload-crop.php' class='btn' style='background-color: #28a745; color: white;'>Upload Crop</a>
                </div>
              </div>
            </div>";
              $sql = "SELECT * FROM `crop` WHERE `FID`=$FID";
              $result = mysqli_query($conn, $sql);
              if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                  $image = str_replace("C:/xampp/htdocs", "", $row['image']);
                  echo "<div class='col-md-6 col-lg-3'>
                <div class='card mt-3'>
                  <div class='card-body text-center'>
                    <img src='images/potato.jpg' alt='Crop Image' style='width: 200px; height: 200px; display: block; margin: 0 auto 10px;'>
                    <h5 class='card-title'>" . $row['name'] . "</h5>
                    <p class='card-text'>Base Price: " . $row['base price'] . "</p>
                    <a href='upload-crop.php' class='btn' style='background-color: #28a745; color: white;'>Update Crop</a>
                    <div class='mt-2'>
                      <button class='btn btn-danger' data-cropid='" . $row['CID'] . "' onclick='deleteCrop(event)'>Delete Crop</button>
                    </div>
                  </div>
                </div>
              </div>";
                }
              }
              ?>
            </div>
          </div>
        </section><br>
        <div class="bar">
          <div class="row">
            <div class="col-sm text-center">Orders</div>
          </div>
        </div>
        <section id="products">
          <div class="container-fluid">
            <div class="row">
              <?php
              

              $sql = "SELECT * FROM `crop` WHERE `CID` = (
                SELECT `CID` 
                FROM `order_details` 
                WHERE `FID` = '$FID'
                LIMIT 1
            )";

              $result = mysqli_query($conn, $sql);

              if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                  $image = str_replace("C:/xampp/htdocs", "", $row['image']);
                  echo "<div class='col-md-6 col-lg-3'>
                  <div class='card mt-3'>
                    <div class='card-body text-center'>
                      <img src='images/corn.jpg' alt='Crop Image' style='width: 200px; height: 200px; display: block; margin: 0 auto 10px;'>
                      <h5 class='card-title'>" . $row['name'] . "</h5>
                      <p class='card-text'>Base Price: " . $row['base price'] . "</p>
                      <a href='upload-crop.php' class='btn' style='background-color: #28a745; color: white;'>Update Crop</a>
                      <div class='mt-2'>
                        <button class='btn btn-danger' data-cropid='" . $row['CID'] . "' onclick='deleteCrop(event)'>Delete Crop</button>
                      </div>
                    </div>
                  </div>
                </div>";
                }
              }
              else{
                echo "<div class='col-md-6 col-lg-3'>
                <div class='card mt-3'>
                  <div class='card-body text-center'>
                    <img src='images/add_icon.jpg' alt='Initial Crop Image' style='width: 200px; height: 200px; display: block; margin: 0 auto 10px;'>
                    <p>No order</p>
                  </div>
                </div>
            </div>";
              }
              ?>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
  <div class="footer">
    <p>@2025 BhajiPala - All Rights Reserved.</p>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const urlParams = new URLSearchParams(window.location.search);
      const cropName = urlParams.get('crop_name');
      const basePrice = urlParams.get('base_price');
      const imageData = urlParams.get('image');

      if (cropName && basePrice && imageData) {
        addCropCard(cropName, basePrice, imageData);
      }
    });

    function addCropCard(cropName, basePrice, imageData) {
      var card = document.createElement('div');
      card.className = 'card mt-3';

      var cardBody = document.createElement('div');
      cardBody.className = 'card-body text-center';

      var img = document.createElement('img');
      img.src = imageData;
      img.alt = 'Crop Image';
      img.style.width = '100px';
      img.style.height = '100px';
      img.style.display = 'block';
      img.style.margin = '0 auto 10px';

      var cardTitle = document.createElement('h5');
      cardTitle.className = 'card-title';
      cardTitle.innerText = cropName;

      var cardText = document.createElement('p');
      cardText.className = 'card-text';
      cardText.innerText = `Base Price: ${basePrice}`;

      var uploadBtn = document.createElement('a');
      uploadBtn.href = 'upload-crop.php';
      uploadBtn.className = 'btn btn-primary';
      uploadBtn.style.backgroundColor = '#28a745';
      uploadBtn.style.color = 'white';
      uploadBtn.innerText = 'Upload Crop';

      var deleteBtn = document.createElement('button');
      deleteBtn.className = 'btn btn-danger mt-2';
      deleteBtn.innerText = 'Delete Crop';
      // deleteBtn.setAttribute('data-cropid', cropId); // Add crop ID to button if available
      deleteBtn.onclick = function (event) {
        deleteCrop(event);
      };

      cardBody.appendChild(img);
      cardBody.appendChild(cardTitle);
      cardBody.appendChild(cardText);
      cardBody.appendChild(uploadBtn);
      cardBody.appendChild(deleteBtn);

      card.appendChild(cardBody);

      // Append card to the card container
      var cardDeck = document.querySelector('.row'); // Assuming the cards are in a row container
      cardDeck.appendChild(card);
    }

    function deleteCrop(event) {
      var cropId = event.target.getAttribute('data-cropid');
      var card = event.target.closest('.card');

      // Make an AJAX request to delete the crop from the database
      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'delete-crop.php', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
          var response = JSON.parse(xhr.responseText);
          if (response.success) {
            card.remove();
          } else {
            alert('Failed to delete crop: ' + response.error);
          }
        }
      };
      xhr.send('crop_id=' + cropId);
    }
  </script>


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