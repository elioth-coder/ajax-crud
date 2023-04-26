<?php
require_once "connection.php";

$sql = "SELECT * FROM names";
$result = $conn->query($sql);
$rows = [];

while($row = $result->fetch_assoc()) {
    $rows[] = $row;
}

$response = [
    "status" => "success",
    "rows" => $rows
];

echo json_encode($response);