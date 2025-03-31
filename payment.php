<?php
session_start();
include("connection.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // PHPMailer library

if (!isset($_SESSION['total_price']) || !isset($_SESSION['passenger_id']) || !isset($_SESSION['email'])) {
    echo "<script>alert('Session expired. Please book again.'); window.location.href='details.php';</script>";
    exit();
}

$total_price = $_SESSION['total_price'];
$passenger_id = $_SESSION['passenger_id'];
$email = $_SESSION['email']; 
$seats = $_SESSION['seats'];
$seats_str = implode(",", $seats);
$gender = $_SESSION['gender'];
$journey_date = $_SESSION['date'];
$departure = $_SESSION['departure'];
$arrival = $_SESSION['arrival'];
$bus_route = $_SESSION['bus_route'];

// ✅ Step 1: Ensure Passenger Exists
$checkPassengerSQL = "SELECT id, name FROM passengers WHERE id = '$passenger_id'";
$result = $conn->query($checkPassengerSQL);
if ($result->num_rows == 0) {
    echo "<script>alert('Error: Passenger not found.'); window.location.href='details.php';</script>";
    exit();
}
$passenger = $result->fetch_assoc();
$name = $passenger['name']; 

// ✅ Step 2: Insert Payment Record
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['checkout'])) {
    $card_name = $conn->real_escape_string($_POST['cardName']);
    $card_number = $conn->real_escape_string($_POST['cardNumber']);
    $expDate = $conn->real_escape_string($_POST['expDate']);
    if (strpos($expDate, '/') !== false) {
        list($exp_month, $exp_year) = explode('/', $expDate);
        $exp_month = trim($exp_month);
        $exp_year = trim($exp_year);
    } else {
        $exp_month = '';
        $exp_year = '';
    }
    
    $cvv = $conn->real_escape_string($_POST['cvv']);

    $paymentSQL = "INSERT INTO payments (passenger_id, name, email, seats, journey_date, departure, arrival, card_name, card_number, exp_month, exp_year, cvv, amount, payment_status)
    VALUES ('$passenger_id', '$name', '$email', '$seats_str', '$journey_date', '$departure', '$arrival', '$card_name', '$card_number', '$exp_month', '$exp_year', '$cvv', '$total_price', 'completed')";

    if ($conn->query($paymentSQL) === TRUE) {
        // ✅ Step 3: Update Booking to Permanent
        $updateSeatSQL = "UPDATE bookings SET status='booked', temp_locked=0, passenger_id='$passenger_id'
        WHERE seats='$seats_str' AND journey_date='$journey_date' AND departure='$departure' AND arrival='$arrival' AND status='temp'";

        if ($conn->query($updateSeatSQL) === TRUE) {
            // ✅ Send Confirmation Email
            try {
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'dulanjanagodigamuwa@gmail.com';  // Replace with your Gmail
                $mail->Password = 'vejg hppo bunh vete';  // Use an App Password from Google
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                $mail->setFrom('dulanjanagodigamuwa@gmail.com', 'Neelawala Express');
                $mail->addAddress($email, $name);

                $mail->isHTML(true);
                $mail->Subject = "Your Bus Ticket Confirmation - Neelawala Express";
                $mail->Body = "
                    <h2>Dear $name,</h2>
                    <p>Thank you for booking with <strong>Neelawala Express</strong>. Here are your ticket details:</p>
                    <hr>
                    <p><strong>Booking Invoice No:</strong> INV-$passenger_id</p>
                    <p><strong>Seats Booked:</strong> $seats_str</p>
                    <p><strong>Amount Paid:</strong> Rs. $total_price</p>
                    <p><strong>Departure:</strong> $departure</p>
                    <p><strong>Arrival:</strong> $arrival</p>
                    <p><strong>Bus Route:</strong> $bus_route</p>
                    <p><strong>Journey Date:</strong> $journey_date</p>
                    <hr>
                    <p><em>We look forward to serving you. Have a safe journey!</em></p>
                    <p><strong>Neelawala Express</strong></p>
                ";

                $mail->send();

            } catch (Exception $e) {
                error_log("Email could not be sent. Error: {$mail->ErrorInfo}");
            }

            // ✅ Redirect to user login with JavaScript alert
            echo "<script>
                alert('Payment successful! Your seats are booked. A confirmation email has been sent.');
                window.location.href='userlogin.php';
            </script>";
            exit();
        } else {
            echo "<script>alert('Error updating seats: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Payment error: " . $conn->error . "');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Invoice</title>
    <style>
/* General Page Styling */
/* General Page Styling with Background Image */
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

/* Wrapper for Split Layout (Bigger Layout) */
.payment-wrapper {
    display: flex;
    background: white;
    width: 800px;  /* Increased width */
    border-radius: 10px;
    box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

/* Left Section - Image (Full Fit) */
.left-section {
    width: 55%;
    background: #eee;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0; /* Remove padding for full image fit */
    overflow: hidden; /* Ensures no extra space around the image */
}

.left-section img {
    width: 100%; /* Make sure image fills the entire width */
    height: 100%; /* Stretch height to fit section */
    object-fit: cover; /* Ensure the image covers without distortion */
}

/* Right Section - Payment Form */
.right-section {
    width: 65%;
    padding: 50px;
    text-align: center;
}

/* Header */
h2 {
    font-size: 25px; /* Bigger text */
    font-weight: bold;
    color: #333;
    margin-bottom: 20px;
}

/* Accepted Cards (Larger) */
.cards {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-bottom: 15px;
}

.cards img {
    width: 100%; /* Bigger cards image */
    height: auto;
}

/* Payment Amount */
.payment-amount {
    font-size: 18px;
    color: #666;
    margin-bottom: 8px;
}

.amount {
    font-size: 22px; /* Bigger text */
    font-weight: bold;
    color: #333;
    margin-bottom: 25px;
}

/* Form Styling */
.form-group {
    text-align: left;
    margin-bottom: 15px; /* More spacing */
}

.form-group label {
    font-weight: bold;
    font-size: 15px; /* Larger font */
    display: block;
    margin-bottom: 6px;
}

.form-group input {
    width: 100%;
    padding: 10px; /* Bigger input fields */
    border: 2px solid #ccc;
    border-radius: 8px;
    font-size: 18px;
}

/* Two-Column Form Row */
.form-row {
    display: flex;
    gap: 15px;
}

.form-row .half {
    width: 50%;
}

/* Payment Button */
button {
    width: 100%;
    background: rgb(40, 165, 36);
    color: white;
    padding: 12px; /* Bigger button */
    font-size: 18px; /* Bigger text */
    font-weight: bold;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    margin-top: 15px;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
}

button:hover {
    background: rgb(43, 165, 39);
}

    </style>
</head>
<body>

<div class="payment-wrapper">
    <!-- Left Section with Image -->
    <div class="left-section">
        <img src="image/g4.jpg" alt="Payment Logo">
    </div>

    <!-- Right Section with Payment Form -->
    <div class="right-section">
        <h2>Pay Invoice</h2>

        <!-- Accepted Cards (Larger) -->
        <div class="cards">
            <img src="image/card_img.png" alt="Accepted Cards"> 
        </div>

        <!-- Payment Amount -->
        <p class="payment-amount">Payment amount</p>
        <h3 class="amount">Rs <?php echo number_format($total_price, 2); ?></h3>

        <form method="POST">
            <div class="form-group">
                <label>Name on card</label>
                <input type="text" name="cardName" placeholder="Enter cardholder name" required>
            </div>

            <div class="form-group">
                <label>Card number</label>
                <input type="text" name="cardNumber" placeholder="0000 0000 0000 0000" required>
            </div>

            <div class="form-row">
                <div class="form-group half">
                    <label>Expiry date</label>
                    <input type="text" name="expDate" placeholder="MM / YY" required>
                </div>
                <div class="form-group half">
                    <label>Security code</label>
                    <input type="text" name="cvv" placeholder="CVV" required>
                </div>
            </div>

            <div class="form-group">
                <label>ZIP/Postal code</label>
                <input type="text" name="zip" placeholder="ZIP code" required>
            </div>

            <button type="submit" name="checkout">
                🔒 Pay Rs <?php echo number_format($total_price, 2); ?>
            </button>
        </form>
    </div>
</div>

</body>
</html>
