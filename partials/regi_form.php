<?php

include("db_connect.php");

if ($_SERVER['REQUEST_METHOD'] == "post") {
    $f_name=$_GET['f_name'];
    $m_name=$_GET['m_name'];
    $l_name=$_GET['l_name'];

    
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="my-4 container">
        <h2>Farmer registration</h2>

        <form class="row g-3" method="post" action="<?php $_PHP_SELF ?>" enctype="multipart/form-data">

            <div class="input-group mb-3">
                <input type="file" class="form-control" id="inputGroupFile02" name="img">
                <label class="input-group-text" for="inputGroupFile02">Upload</label>
            </div>

            <div class="col-md-4">
                <label for="inputEmail4" class="form-label">First name</label>
                <input type="text" name="f_name" class="form-control" id="inputEmail4" required>
            </div>
            <div class="col-md-4">
                <label for="inputEmail4" class="form-label">middle name</label>
                <input type="text" name="m_name" class="form-control" id="inputEmail4" required>
            </div>
            <div class="col-md-4">
                <label for="inputPassword4" class="form-label">last name</label>
                <input type="text" name="l_name" class="form-control" id="inputPassword4" required>
            </div>

            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Email</label>
                <input type="email" name="f_email" class="form-control" id="inputEmail4" required>
            </div>
            <div class="col-md-6">
                <label for="inputPassword4" class="form-label">Phone</label>
                <input type="text" name="f_phone" class="form-control" id="inputPassword4" required>
            </div>

            <div class="col-12">
                <label for="inputAddress" class="form-label">Address</label>
                <input type="text" name="f_add" class="form-control" id="inputAddress" placeholder="1234 Main St" required>
            </div>

            <div class="col-md-6">
                <label for="inputPassword4" class="form-label">Password</label>
                <input type="text" name="f_pass" class="form-control" id="inputPassword4" required>
            </div>
            <div class="col-md-6">
                <label for="inputPassword4" class="form-label">confirm password</label>
                <input type="text" name="f_c_pass" class="form-control" id="inputPassword4" required>
            </div>

            <div class="col-md-6">
                <label for="inputState" class="form-label">State</label>
                <select id="inputState" name="f_state" class="form-select" required>
                    <option selected>Choose...</option>
                    <option>Maharashtra</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="inputState" class="form-label">city</label>
                <select id="inputState" name="f_city" class="form-select" required>
                    <option selected>Choose...</option>
                    <option>pune</option>
                    <option>Mumbai</option>
                    <option>Nashik</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="inputZip" class="form-label">Zip</label>
                <input type="text" name="f_zip" class="form-control" id="inputZip" required>
            </div>
            <div class="col-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="gridCheck">
                    <label class="form-check-label" for="gridCheck">
                        Check me out
                    </label>
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Sign in</button>
            </div>
        </form>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>