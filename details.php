<?php 
session_start();
include("connection.php");

if (!isset($_SESSION['seats']) || empty($_SESSION['seats'])) {
    echo "<script>alert('Session expired or booking data missing. Please try again.'); window.location.href='seat_selection.php';</script>";
    exit();
}

$seats = $_SESSION['seats']; // Directly use as array
$seat_count = count($seats);
$total_price = $_SESSION['total_price'];
$journey_date = $_SESSION['date'];
$departure = $_SESSION['departure'];
$arrival = $_SESSION['arrival'];
$bus_route = $_SESSION['bus_route'] ?? ''; // Ensure it exists
$gender = $_SESSION['gender'] ?? 'Other'; // Ensure gender is set

// Store the user details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $mobile = $conn->real_escape_string($_POST['mobile']);
    $id_number = $conn->real_escape_string($_POST['id_number']);
    $email = $conn->real_escape_string($_POST['email']);

    if (!empty($name) && !empty($mobile) && !empty($id_number) && !empty($email)) {
        // Start a transaction to ensure data consistency
        $conn->begin_transaction();

        try {
            // Check if user exists in `users` table
            $user_check = $conn->prepare("SELECT id FROM users WHERE id_number = ?");
            $user_check->bind_param("s", $id_number);
            $user_check->execute();
            $user_check->store_result();

            if ($user_check->num_rows == 0) {
                // Insert user if not exists
                $insert_user = $conn->prepare("INSERT INTO users (name, id_number, mobile, email) VALUES (?, ?, ?, ?)");
                $insert_user->bind_param("ssss", $name, $id_number, $mobile, $email);
                $insert_user->execute();
            }
            
            // Insert booking details into `passengers` table
            $insert_passenger = $conn->prepare("
                INSERT INTO passengers (name, mobile, id_number, email, seats, journey_date, departure, arrival, gender, total_price, bus_route)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $seats_string = implode(",", $seats);
            $insert_passenger->bind_param("sssssssssis", $name, $mobile, $id_number, $email, $seats_string, $journey_date, $departure, $arrival, $gender, $total_price, $bus_route);
            $insert_passenger->execute();

            // Store passenger ID in session for payment reference
            $_SESSION['passenger_id'] = $conn->insert_id;
            $_SESSION['email'] = $email;  // ✅ Store email for later use in payment.php

            // Commit transaction
            $conn->commit();
        
            
            // Redirect to payment page
            header("Location: payment.php");
            exit();

        } catch (Exception $e) {
            // Rollback on error
            $conn->rollback();
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passenger Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <style>
       /* General Styles */
       body {
    font-family: 'Arial', sans-serif;
    background: linear-gradient(rgba(43, 38, 38, 0.85), rgba(9, 179, 51, 0.85)), 
                url('image/C.jpg');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
 
}


 /* Navbar */
 nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 5%;
    background: #ffffff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.logo img {
    width: 200px;
}

.links {
    display: flex;
    gap: 20px;
}

.link a {
    font-weight: 500;
    color: #333;
    text-decoration: none;
    transition: color 0.3s ease;
}

.link a:hover {
    color: #0bbb5a;
}

/* Style the button */
.buttons button {
    padding: 15px 20px;
    border: none;
    border-radius: 5px;
    background: rgb(12, 112, 10);
    cursor: pointer;
    transition: background 0.3s ease;
    width: 180px;  /* Set a fixed width for proper text wrapping */
    white-space: normal; /* Allows text to wrap */
    line-height: 1.2; /* Adjust line spacing */
    text-align: center; /* Ensure text is centered */
    font-size: 14px; /* Adjust font size for better fit */
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Ensure white text inside the button */
.buttons button a {
    color: white !important; /* Force white text */
    text-decoration: none; /* Remove underline */
    font-weight: bold;
}

/* Change button color on hover */
.buttons button:hover {
    background: #08963e;
}


.booking-container {
    background: rgba(255, 255, 255, 0.15); /* Transparent white */
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    width: 80%;
    max-width: 900px;
    backdrop-filter: blur(10px); /* Glassmorphism Effect */
}

.booking-container h2 {
    font-size: 24px;
    font-weight: bold;
    color: #fff;
    margin-bottom: 20px;
}


        /* Container */
        .container {
            background: #ffffff;
            max-width: 550px;
            width: 100%;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
            transition: 0.3s ease-in-out;
            margin-top: 90px;
        }

        .container:hover {
            transform: scale(1.02);
        }

        /* Booking Summary */
        .card {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 15px;
            border-left: 5px solid #1e8a08;
        }

        .card h5 {
            color: #1e8a08;
            margin-bottom: 10px;
            font-size: 18px;
        }

        .card p {
            font-size: 14px;
            color: #555;
            margin: 5px 0;
        }

        /* Form */
        .form-label {
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: 0.3s ease-in-out;
        }

        .form-control:focus {
            border-color: #1e8a08;
            box-shadow: 0px 0px 5px rgba(30, 138, 8, 0.5);
            outline: none;
        }

        /* Submit Button */
        .btn-primary {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            background: #1e8a08;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        .btn-primary:hover {
            background: #166506;
        }
    </style>

</head>
<body>


<nav>
    <div class="logo">
        <img src="image/logo.png" alt="Logo" />
    </div>
    <div class="links">
        <div class="link"><a href="home.php">Home</a></div>
        <div class="link"><a href="Bustime.php">Bus Timetables</a></div>
        <div class="link"><a href="service.php">Service</a></div>
        <div class="link"><a href="gallery.php">Gallery</a></div>
        <div class="link"><a href="contact.php">Contact</a></div>
    </div>
    <div class="buttons">
            <button data-aos="fade-up" data-aos-duration="1200" data-aos-delay="7000"><a href="userlogin.php">Login and Cancelation Policy</a></button>
        </div>
</nav>

<div class="container mt-4">
    <h2 class="text-center">Confirm Your Booking</h2>

    <div class="card p-3 mb-3">
        <h5>Booking Summary</h5>
        <p><strong>Seats Selected:</strong> <?= implode(", ", $seats); ?></p>
        <p><strong>Journey Date:</strong> <?= $journey_date; ?></p>
        <p><strong>Departure:</strong> <?= $departure; ?></p>
        <p><strong>Arrival:</strong> <?= $arrival; ?></p>
        <p><strong>Gender:</strong> <?= ucfirst($_SESSION['gender']); ?></p>  
        <p><strong>Total Price:</strong> Rs <?= $total_price; ?></p>
    </div>

    <form method="POST">
        <label for="name" class="form-label">Full Name:</label>
        <input type="text" class="form-control mb-3" name="name" required>

        <label for="mobile" class="form-label">Mobile Number:</label>
        <input type="text" class="form-control mb-3" name="mobile" required>

        <label for="id_number" class="form-label">NIC/Passport Number:</label>
        <input type="text" class="form-control mb-3" name="id_number" required>

        <label for="email" class="form-label">Email Address:</label>
        <input type="email" class="form-control mb-3" name="email" required>

        <button type="submit" class="btn btn-primary">Proceed to Payment</button>
    </form>
</div>

</body>
</html>
