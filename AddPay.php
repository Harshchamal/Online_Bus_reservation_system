<?php 
session_start();
include("connection.php");
include("function.php");

$user_data = check_login($conn);

// Ensure session data is available
if (!isset($_SESSION['passenger_id']) || !isset($_SESSION['total_price'])) {
    echo "<script>alert('No booking found. Redirecting to booking page.'); window.location.href='seat_selection.php';</script>";
    exit();
}

$passenger_id = $_SESSION['passenger_id']; 
$total_price = $_SESSION['total_price']; // Use the actual total price from session

if(isset($_POST['checkout'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $address = $conn->real_escape_string($_POST['address']);
    $city = $conn->real_escape_string($_POST['city']);
    $state = $conn->real_escape_string($_POST['state']);
    $zip = $conn->real_escape_string($_POST['zip']);
    $card_name = $conn->real_escape_string($_POST['cardName']);
    $card_number = $conn->real_escape_string($_POST['cardNumber']);
    $exp_month = $conn->real_escape_string($_POST['expM']);
    $exp_year = $conn->real_escape_string($_POST['expYear']);
    $cvv = $conn->real_escape_string($_POST['cvv']);
    
    // Validate fields
    if (empty($name) || empty($email) || empty($address) || empty($city) || empty($state) || empty($zip) ||
        empty($card_name) || empty($card_number) || empty($exp_month) || empty($exp_year) || empty($cvv)) {
        echo "<script>alert('Please fill in all required fields.');</script>";
    } else {
        // Insert payment details into the database
        $stmt = $conn->prepare("INSERT INTO payment (passenger_id, amount, name, email, address, city, state, zip_code, card_name, card_number, exp_month, exp_year, cvv) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->bind_param("idssssssssssi", $passenger_id, $total_price, $name, $email, $address, $city, $state, $zip, $card_name, $card_number, $exp_month, $exp_year, $cvv);

        if ($stmt->execute()) {
            echo ("<script>
                alert('Payment Successful! Redirecting...');
                window.location.href='paySuccess.php';
            </script>");
        } else {
            echo "<script>alert('Error processing payment. Please try again.');</script>";
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="cssfile/payment.css">

</head>
<body>

<div class="container">

    <form method="POST">

        <div class="row">
            <div class="col">
                <h3 class="title">Billing Address</h3>

                <div class="inputBox">
                    <span>Amount You Pay :</span>
                    <input type="number" value="<?php echo $total_price; ?>" name="amount" readonly>
                </div>

                <div class="inputBox">
                    <span>Name :</span>
                    <input type="text" value="<?php echo $user_data['username']; ?>" name="name" required>
                </div>

                <div class="inputBox">
                    <span>Email :</span>
                    <input type="email" value="<?php echo $user_data['email']; ?>" name="email" required>
                </div>
                <div class="inputBox">
                    <span>Address :</span>
                    <input type="text" name="address" required>
                </div>
                <div class="inputBox">
                    <span>City :</span>
                    <input type="text" placeholder="Enter your city" name="city" required>
                </div>

                <div class="flex">
                    <div class="inputBox">
                        <span>State :</span>
                        <input type="text" placeholder="Enter state" name="state" required>
                    </div>
                    <div class="inputBox">
                        <span>Zip Code :</span>
                        <input type="text" placeholder="123456" name="zip" required>
                    </div>
                </div>

            </div>

            <div class="col">
                <h3 class="title">Payment</h3>

                <div class="inputBox">
                    <span>Cards Accepted :</span>
                    <img src="image/card_img.png" alt="">
                </div>
                <div class="inputBox">
                    <span>Name on Card :</span>
                    <input type="text" placeholder="Mr. John Doe" name="cardName" required>
                </div>
                <div class="inputBox">
                    <span>Credit Card Number :</span>
                    <input type="number" placeholder="1111-2222-3333-4444" name="cardNumber" required>
                </div>
                <div class="inputBox">
                    <span>Exp Month :</span>
                    <input type="text" placeholder="January" name="expM" required>
                </div>

                <div class="flex">
                    <div class="inputBox">
                        <span>Exp Year :</span>
                        <input type="number" placeholder="2025" name="expYear" required>
                    </div>
                    <div class="inputBox">
                        <span>CVV :</span>
                        <input type="text" placeholder="123" name="cvv" required>
                    </div>
                </div>

            </div>
    
        </div>

        <input type="submit" value="Proceed to Checkout" class="submit-btn" name="checkout">

    </form>

</div>    
    
</body>
</html>
