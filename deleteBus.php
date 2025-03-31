<?php
include("connection.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ensure ID is an integer
    $id = intval($id);

    $query = "DELETE FROM bus WHERE id='$id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Bus deleted successfully!'); window.location.href='ManagesBuses.php';</script>";
    } else {
        echo "<script>alert('Error deleting bus.'); window.location.href='ManagesBuses.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.location.href='ManagesBuses.php';</script>";
}
?>
