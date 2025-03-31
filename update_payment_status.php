<?php
include("connection.php");

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];
$status = $data['status'];

$conn->query("UPDATE payments SET payment_status='$status' WHERE id='$id'");
echo json_encode(["message" => "Payment status updated successfully."]);
?>
