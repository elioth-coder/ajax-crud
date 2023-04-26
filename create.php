<?php
require_once "connection.php";

sleep(3);

$last_name  = $_POST['last_name'];
$first_name = $_POST['first_name'];

$sql = "INSERT INTO names (last_name, first_name) VALUES ('$last_name', '$first_name')";
$success = $conn->query($sql);

if($success) {
    $response = [
        "status" => "success",
        "message" => "Successfully inserted data!"
    ];
    
    echo json_encode($response);
} else {
    $response = [
        "status" => "error",
        "message" => "Failed to insert data!"
    ];
    
    echo json_encode($response); 
}



?>