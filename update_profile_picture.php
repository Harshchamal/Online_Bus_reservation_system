<?php
session_start();
include("connection.php");

if (!isset($_SESSION['passenger_id'])) {
    echo json_encode(["status" => "error", "message" => "User not logged in."]);
    exit();
}

$passenger_id = $_SESSION['passenger_id'];

// Ensure the `uploads/` directory exists
$target_dir = "uploads/";
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}

// Validate file upload
if (!isset($_FILES['profile_picture']) || $_FILES['profile_picture']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(["status" => "error", "message" => "No file uploaded or upload error."]);
    exit();
}

$file_name = basename($_FILES["profile_picture"]["name"]);
$target_file = $target_dir . time() . "_" . $file_name; // Avoid file name conflict
$image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Validate file type
$allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
if (!in_array($image_file_type, $allowed_types)) {
    echo json_encode(["status" => "error", "message" => "Invalid file type. Only JPG, JPEG, PNG, and GIF allowed."]);
    exit();
}

// Move uploaded file
if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
    // Update the database with the new file path
    $update_picture_query = "UPDATE passengers SET profile_picture = ? WHERE id = ?";
    $stmt = $conn->prepare($update_picture_query);
    $stmt->bind_param("si", $target_file, $passenger_id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Profile picture updated successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Database update failed."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Failed to move uploaded file."]);
}
?>
