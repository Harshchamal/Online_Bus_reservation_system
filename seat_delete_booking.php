<?php
include("connection.php");
header('Content-Type: application/json');

// Get JSON input from JavaScript
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id']) || empty($data['id'])) {
    echo json_encode(["success" => false, "message" => "Invalid booking ID."]);
    exit;
}

$bookingId = intval($data['id']);

// Delete the booking
$sql = "DELETE FROM bookings WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $bookingId);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Booking canceled successfully!"]);
} else {
    echo json_encode(["success" => false, "message" => "Error canceling booking."]);
}

$stmt->close();
$conn->close();
?>
