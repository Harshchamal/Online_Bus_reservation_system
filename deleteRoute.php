<?php
include("connection.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ensure ID is an integer
    $id = intval($id);

    $query = "DELETE FROM route WHERE id='$id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Route deleted successfully!'); window.location.href='adminDash.php';</script>";
    } else {
        echo "<script>alert('Error deleting route.'); window.location.href='adminDash.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.location.href='adminDash.php';</script>";
}
?>
