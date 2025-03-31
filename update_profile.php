<?php
session_start();
include("connection.php");

// Check if user is logged in
if (!isset($_SESSION['passenger_id'])) {
    echo json_encode(["status" => "error", "message" => "User not logged in"]);
    exit();
}

$passenger_id = $_SESSION['passenger_id'];

// Get form data
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$mobile = isset($_POST['mobile']) ? trim($_POST['mobile']) : '';
$address = isset($_POST['address']) ? trim($_POST['address']) : '';

if (empty($name) || empty($email) || empty($mobile)) {
    echo json_encode(["status" => "error", "message" => "All fields except address are required."]);
    exit();
}

// Update the passenger's details
$query = "UPDATE passengers SET name = ?, email = ?, mobile = ?, address = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssi", $name, $email, $mobile, $address, $passenger_id);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Profile updated successfully!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to update profile."]);
}

$stmt->close();
$conn->close();
?>
