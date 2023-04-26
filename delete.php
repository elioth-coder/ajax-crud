<?php
require_once "connection.php";

$sql = "DELETE FROM names WHERE id=" . $_GET['id'];
$success = $conn->query($sql);

if($success) {
    $response = [
        "status" => "success",
        "message" => "Successfully deleted data!"
    ];
    
    echo json_encode($response);
} else {
    $response = [
        "status" => "error",
        "message" => "Failed to delete data!"
    ];
    
    echo json_encode($response); 
}



?>