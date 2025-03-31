<?php
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $bus_name = $_POST['bus_name'];
    $tel = $_POST['tel'];

    $query = "UPDATE bus SET Bus_Name='$bus_name', Tel='$tel' WHERE id='$id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Bus updated successfully!'); window.location.href='ManagesBuses.php';</script>";
    } else {
        echo "<script>alert('Error updating bus'); window.location.href='ManagesBuses.php';</script>";
    }
}
?>
