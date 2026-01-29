<?php
include("./db_connect.php");
session_start();

$email = $_SESSION['email'];

if (isset($email)) {
    $stmt = $conn->prepare("SELECT name, email FROM farmer WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $farmer = $result->fetch_assoc();
        echo json_encode($farmer);
    } else {
        echo json_encode(["error" => "Farmer not found."]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "No email found in session."]);
}
?>
