<?php
require_once "connection.php";

sleep(3);

$last_name  = $_POST['last_name'];
$first_name = $_POST['first_name'];
$id = $_POST['id'];

$sql = "UPDATE names SET last_name='$last_name', first_name='$first_name' WHERE id=$id";
$success = $conn->query($sql);

if($success) {
    $response = [
        "status" => "success",
        "message" => "Successfully updated data!"
    ];
    
    echo json_encode($response);
} else {
    $response = [
        "status" => "error",
        "message" => "Failed to update data!"
    ];
    
    echo json_encode($response); 
}
?>