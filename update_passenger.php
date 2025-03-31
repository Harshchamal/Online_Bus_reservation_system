<?php
include("connection.php");

$data = json_decode(file_get_contents("php://input"), true);

$id = intval($data['id']);
$name = $conn->real_escape_string($data['name']);
$mobile = $conn->real_escape_string($data['mobile']);
$email = $conn->real_escape_string($data['email']);

$query = "UPDATE passengers SET name='$name', mobile='$mobile', email='$email' WHERE id=$id";

if ($conn->query($query) === TRUE) {
    echo json_encode(["success" => true, "message" => "Passenger updated successfully!"]);
} else {
    echo json_encode(["success" => false, "message" => "Error updating passenger."]);
}
?>
