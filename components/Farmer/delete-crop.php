<?php
include("./db_connect.php");

if (isset($_POST['crop_id'])) {
    $crop_id = $_POST['crop_id'];

    // Prepare and execute the delete statement
    $sql = "DELETE FROM `crop` WHERE `CID` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $crop_id);

    if ($stmt->execute()) {
        $response = array('success' => true);
    } else {
        $response = array('success' => false, 'error' => $stmt->error);
    }

    $stmt->close();
    $conn->close();

    echo json_encode($response);
}
?>
