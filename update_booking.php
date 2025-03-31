<?php
include("connection.php");
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id']) || empty($data['id']) || empty($data['journey_date']) || empty($data['departure']) || empty($data['arrival'])) {
    echo json_encode(["success" => false, "message" => "All fields are required."]);
    exit;
}

$bookingId = intval($data['id']);
$journeyDate = $data['journey_date'];
$departure = $data['departure'];
$arrival = $data['arrival'];

$sql = "UPDATE bookings SET journey_date = ?, departure = ?, arrival = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssi", $journeyDate, $departure, $arrival, $bookingId);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Booking updated successfully!"]);
} else {
    echo json_encode(["success" => false, "message" => "Error updating booking."]);
}

$stmt->close();
$conn->close();
?>
