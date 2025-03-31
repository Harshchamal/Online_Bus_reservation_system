<?php
include("connection.php");

// Use the correct form input names from your modal
$bus_number = $_POST['bus_number'];
$conductor_number = $_POST['conductor_number'];

$query = "INSERT INTO bus (bus_number, conductor_number) VALUES ('$bus_number', '$conductor_number')";

if (mysqli_query($conn, $query)) {
    echo "<script>alert('Bus added successfully!'); window.location.href='ManagesBuses.php';</script>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
