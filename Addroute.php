<?php
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $via_city = $_POST['via_city'];
    $destination = $_POST['destination'];
    $bus_name = $_POST['bus_name'];
    $departure_date = $_POST['departure_date'];
    $departure_time = $_POST['departure_time'];
    $cost = $_POST['cost'];

    $query = "INSERT INTO route (via_city, destination, bus_name, departure_date, departure_time, cost) 
              VALUES ('$via_city', '$destination', '$bus_name', '$departure_date', '$departure_time', '$cost')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Route added successfully!'); window.location.href='adminDash.php';</script>";
    } else {
        echo "<script>alert('Error adding route'); window.location.href='adminDash.php';</script>";
    }
}
?>
