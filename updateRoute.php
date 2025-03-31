<?php
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $via_city = $_POST['via_city'];
    $destination = $_POST['destination'];
    $bus_name = $_POST['bus_name'];
    $departure_date = $_POST['departure_date'];
    $departure_time = $_POST['departure_time'];
    $cost = $_POST['cost'];

    $query = "UPDATE route SET 
                via_city='$via_city', 
                destination='$destination', 
                bus_name='$bus_name', 
                departure_date='$departure_date', 
                departure_time='$departure_time', 
                cost='$cost' 
              WHERE id='$id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Route updated successfully!'); window.location.href='adminDash.php';</script>";
    } else {
        echo "<script>alert('Error updating route'); window.location.href='adminDash.php';</script>";
    }
}
?>
