<?php
require_once __DIR__ . '/vendor/autoload.php';
include("connection.php");

use Mpdf\Mpdf;

// Set the date (from query or default to today)
$date = $_GET['date'] ?? date('Y-m-d');

// Fetch bookings for the day
$sql = "SELECT * FROM passengers WHERE journey_date = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $date);
$stmt->execute();
$result = $stmt->get_result();

// Prepare HTML content
$html = '<h2 style="text-align:center;">Bus Booking Report - ' . htmlspecialchars($date) . '</h2>';
$html .= '
<table border="1" width="100%" cellspacing="0" cellpadding="8" style="border-collapse: collapse; font-family: Arial; font-size: 14px;">
    <thead style="background-color: #2c3e50; color: white;">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Route</th>
            <th>Seats</th>
            <th>Gender</th>
            <th>Departure</th>
            <th>Arrival</th>
            <th>Status</th>
            <th>Total</th>
            <th>Booked At</th>
        </tr>
    </thead>
    <tbody>
';

while ($row = $result->fetch_assoc()) {
    $html .= '<tr>
        <td>' . $row['id'] . '</td>
        <td>' . htmlspecialchars($row['name']) . '</td>
        <td>' . htmlspecialchars($row['bus_route']) . '</td>
        <td>' . htmlspecialchars($row['seats']) . '</td>
        <td>' . ucfirst($row['gender']) . '</td>
        <td>' . htmlspecialchars($row['departure']) . '</td>
        <td>' . htmlspecialchars($row['arrival']) . '</td>
        <td>' . ($row['is_canceled'] ? 'Cancelled' : 'Booked') . '</td>
        <td>Rs ' . number_format($row['total_price'], 2) . '</td>
        <td>' . $row['created_at'] . '</td>
    </tr>';
}

$html .= '</tbody></table>';

// Initialize and generate PDF
$mpdf = new Mpdf();
$mpdf->SetTitle("Bus Booking Report - $date");
$mpdf->WriteHTML($html);
$mpdf->Output("Booking_Report_$date.pdf", 'I'); // I = inline display in browser
?>
