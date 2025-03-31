<?php
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bus_name = $_POST['bus_name'];
    $tel = $_POST['tel'];

    $query = "INSERT INTO bus (Bus_Name, Tel) VALUES ('$bus_name', '$tel')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Bus added successfully!'); window.location.href='ManagesBuses.php';</script>";
    } else {
        echo "<script>alert('Error adding bus'); window.location.href='ManagesBuses.php';</script>";
    }
}
?>
