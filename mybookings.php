<?php
session_start();
include("connection.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // PHPMailer library

if (!isset($_SESSION['passenger_id'])) {
    echo "<script>alert('Please log in to access your dashboard.'); window.location.href='userlogin.php';</script>";
    exit();
}

$passenger_id = $_SESSION['passenger_id'];

// ✅ Fetch User Booking Details
$user_query = "SELECT * FROM passengers WHERE id = ?";
$stmt = $conn->prepare($user_query);
$stmt->bind_param("i", $passenger_id);
$stmt->execute();
$user_result = $stmt->get_result();

if ($user_result->num_rows > 0) {
    $user = $user_result->fetch_assoc();
} else {
    echo "<script>alert('Booking not found.'); window.location.href='userlogin.php';</script>";
    exit();
}

// ✅ Refund Policy Calculation (BEFORE Canceling)
$journey_date = strtotime($user['journey_date']);
$current_date = time();
$time_left = $journey_date - $current_date;
$refund_percentage = 0;

// Refund Conditions (Apply Before HTML)
if ($time_left > 2592000) { // More than 30 days before departure
    $refund_percentage = 100;
} elseif ($time_left > 86400) { // More than 1 day before departure
    $refund_percentage = 80;
} else {
    $refund_percentage = 0; // No refund
}

// Calculate Refund Amount
$refund_amount = ($user['total_price'] * $refund_percentage) / 100;
$refund_amount = round($refund_amount, 2); // Round to 2 decimal places

// ✅ Handle Booking Cancellation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel_booking'])) {
    $cancel_query = "UPDATE passengers SET is_canceled = 1, refund_amount = ?, wallet_balance = wallet_balance + ? WHERE id = ?";
    $stmt = $conn->prepare($cancel_query);
    $stmt->bind_param("dii", $refund_amount, $refund_amount, $passenger_id);


    if ($stmt->execute()) {
        // ✅ Send Email Notification
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'dulanjanagodigamuwa@gmail.com'; // Replace with your Gmail
            $mail->Password = 'vejg hppo bunh vete'; // Use an App Password from Google
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // ✅ Email Setup
            $mail->setFrom('dulanjanagodigamuwa@gmail.com', 'Neelawala Express');
            $mail->addAddress($user['email'], $user['name']);

            $mail->isHTML(true);
            $mail->Subject = "Booking Cancellation & Refund Notice - Neelawala Express";
            $mail->Body = "
                <h2>Dear {$user['name']},</h2>
                <p>Your booking has been successfully canceled.</p>
                <p><strong>Invoice No:</strong> INV-{$user['id']}</p>
                <p><strong>Seats:</strong> {$user['seats']}</p>
                <p><strong>Journey Date:</strong> {$user['journey_date']}</p>
                <p><strong>Departure:</strong> {$user['departure']}</p>
                <p><strong>Arrival:</strong> {$user['arrival']}</p>
                <hr>
                <p><strong>Refund Policy:</strong> {$refund_percentage}% Refund</p>
                <p><strong>Refund Amount:</strong> Rs. " . number_format($refund_amount, 2) . "</p>
                <hr>
                <p>If you have any refund concerns, please join our <strong>Live Chat Support</strong> using your Invoice No: <strong>INV-{$user['id']}</strong>.</p>
                <p><a href='https://yourwebsite.com/livechat?invoice={$user['id']}' target='_blank'><strong>Live Chat Support</strong></a></p>
                <p>Thank you for choosing <strong>Neelawala Express</strong>.</p>
            ";

            $mail->send();
        } catch (Exception $e) {
            error_log("Email could not be sent. Error: {$mail->ErrorInfo}");
        }

        // ✅ Redirect with a delay for better UX
        echo "<script>
            alert('Booking canceled successfully. Refund Rs. " . number_format($refund_amount, 2) . " credited to your wallet. An email has been sent.');
            setTimeout(function() {
                window.location.href='mybookings.php';
            }, 2000);
        </script>";
        exit();
    } else {
        echo "<script>alert('Error canceling booking.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="cssfile/mybookings.css">
    <style>
        body {
    font-family: 'Arial', sans-serif;
    background: linear-gradient(rgba(43, 38, 38, 0.85), rgba(9, 179, 51, 0.85)), 
                url('image/C.jpg');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}


/* 🚨 Refund Notice Styling */
.refund-notice {
    background: #fff3cd;
    border: 2px solid #ffc107;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 10px;
    text-align: center;
    max-width: 900px;
    margin: auto;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
}

.refund-notice h1 {
    font-size: 22px;
    color: #d9534f;
    margin-bottom: 10px;
}

.refund-notice p {
    font-size: 16px;
    color: #333;
    line-height: 1.5;
}

.refund-notice .refund-amount {
    font-weight: bold;
    color: #28a745;
    font-size: 18px;
}



    </style>
</head>
<body>
    <div class="container">
        <h2 class="settings-title">My Bookings</h2>

        <div class="settings-container">
            <!-- Sidebar Navigation -->
            <div class="sidebar">
                <a href="dashboard.php">My Profile</a>
                <a href="mybookings.php" class="active">My Bookings</a>
                <a href="LiveChat.php">Chat Live</a>
            </div>

            <div class="content">
    <!-- 🚨 Refund Policy Notice -->
    <div class="refund-notice">
        <h1>🚨 Important Notice: Refund Policy</h1>
        <p>
            We understand that plans can change. If you cancel your booking, you will receive a 
            <strong><?= $refund_percentage; ?>% refund</strong>. 
            The remaining <strong><?= 100 - $refund_percentage; ?>%</strong> is a non-refundable service charge, 
            which helps cover operational and administrative costs.
        </p>
        <p><strong>Refund Amount:</strong> 
            <span class="refund-amount">Rs. <?= number_format($refund_amount, 2); ?></span>
        </p>
    </div>

    <!-- 📌 Booking Details Section (Now Below the Refund Notice) -->
    <h3>Booking Details</h3>
    <div class="booking-card">
        <table class="table">
            <tbody>
                <tr>
                    <td><strong>Booking ID:</strong></td>
                    <td><?= htmlspecialchars($user['id']); ?></td>
                </tr>
                <tr>
                    <td><strong>Seats:</strong></td>
                    <td><?= htmlspecialchars($user['seats']); ?></td>
                </tr>
                <tr>
                    <td><strong>Journey Date:</strong></td>
                    <td><?= htmlspecialchars($user['journey_date']); ?></td>
                </tr>
                <tr>
                    <td><strong>Departure:</strong></td>
                    <td><?= htmlspecialchars($user['departure']); ?></td>
                </tr>
                <tr>
                    <td><strong>Arrival:</strong></td>
                    <td><?= htmlspecialchars($user['arrival']); ?></td>
                </tr>
                <tr>
                    <td><strong>Gender:</strong></td>
                    <td><?= ucfirst(htmlspecialchars($user['gender'])); ?></td>
                </tr>
                <tr>
                    <td><strong>Departure Time:</strong></td>
                    <td><?= htmlspecialchars($user['departure_time']); ?></td>
                </tr>
                <tr>
                    <td><strong>Total Price:</strong></td>
                    <td>Rs <?= number_format($user['total_price'], 2); ?></td>
                </tr>
                <tr>
                    <td><strong>Status:</strong></td>
                    <td>
                        <?php if ($user['is_canceled'] == 0): ?>
                            <span class="text-success">Active</span>
                        <?php else: ?>
                            <span class="text-danger">Canceled</span>
                        <?php endif; ?>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Cancel Button -->
        <?php if ($user['is_canceled'] == 0): ?>
            <form method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                <input type="hidden" name="cancel_booking" value="<?= htmlspecialchars($user['id']); ?>">
                <button type="submit" class="btn btn-danger w-100">Cancel Booking</button>
            </form>
        <?php else: ?>
            <button class="btn btn-secondary w-100" disabled>Booking Canceled</button>
        <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
