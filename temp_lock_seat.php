<?php
include("connection.php");
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['seats']) || !is_array($data['seats']) || empty($data['seats'])) {
    echo json_encode(["success" => false, "message" => "No seats selected."]);
    exit;
}

$seats = implode(",", array_map('intval', $data['seats']));
$expire_time = date("Y-m-d H:i:s", strtotime("+5 minutes"));

$query = "INSERT INTO temp_bookings (seats, expire_time) VALUES ('$seats', '$expire_time') 
          ON DUPLICATE KEY UPDATE expire_time='$expire_time'";

if ($conn->query($query) === TRUE) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => $conn->error]);
}

$conn->close();
?>
