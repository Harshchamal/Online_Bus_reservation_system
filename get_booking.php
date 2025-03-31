<?php
include("connection.php");
header('Content-Type: application/json');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(["success" => false, "message" => "Invalid booking ID."]);
    exit;
}

$bookingId = intval($_GET['id']);

$sql = "SELECT * FROM bookings WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $bookingId);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

if ($booking) {
    echo json_encode(["success" => true, "booking" => $booking]);
} else {
    echo json_encode(["success" => false, "message" => "Booking not found."]);
}

$stmt->close();
$conn->close();
?>
