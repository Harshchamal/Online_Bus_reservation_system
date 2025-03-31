<?php
include("connection.php");

// Remove temp locks older than 15 minutes
$conn->query("DELETE FROM bookings WHERE status='temp' AND created_at < (NOW() - INTERVAL 15 MINUTE)");
$conn->close();
?>
