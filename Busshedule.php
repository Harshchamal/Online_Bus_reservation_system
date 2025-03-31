<?php
session_start();
include("connection.php");


$departure_query = "SELECT DISTINCT via_city FROM route ORDER BY via_city ASC";
$departure_result = $conn->query($departure_query);

$arrival_query = "SELECT DISTINCT destination FROM route ORDER BY destination ASC";
$arrival_result = $conn->query($arrival_query);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['pickup_point'] = $_POST['pickup_point'] ?? '';
    $_SESSION['drop_point'] = $_POST['drop_point'] ?? '';
    $_SESSION['date'] = $_POST['date'] ?? '';
}

$selected_pickup = $_SESSION['pickup_point'] ?? '';
$selected_drop = $_SESSION['drop_point'] ?? '';
$selected_date = $_SESSION['date'] ?? '';

$sqldata = [];

if ($selected_pickup && $selected_drop && $selected_date) {
    $sql = "
        SELECT r.*, rs.schedule_date, rs.schedule_time
        FROM route r
        INNER JOIN route_schedule rs ON r.id = rs.route_id
        WHERE r.via_city = '$selected_pickup'
          AND r.destination = '$selected_drop'
          AND rs.schedule_date = '$selected_date'
    ";

    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $sqldata[] = $row;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Available Buses - Neelawala Express</title>
    <link rel="stylesheet" href="cssfile/Shedule.css">
    <style>
        /* General Styling */
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
               background: linear-gradient(rgba(43, 38, 38, 0.85), rgba(9, 179, 51, 0.85)), url('image/10.jpg');
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

        .buttons button {
    padding: 15px 20px;
    border: none;
    border-radius: 5px;
    background: rgb(12, 112, 10);
    color: #fff;
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

.buttons button:hover {
    background: #08963e;
}

        /* Booking Section */
        .booking-section {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('image/bus-bg.jpg');
            background-size: cover;
            background-position: center;
            padding: 50px 5%;
            text-align: center;
            color: white;
        }

        .booking-container {
            max-width: 800px;
            margin: auto;
            background: rgba(255, 255, 255, 0.15);
            padding: 20px;
            border-radius: 10px;
            backdrop-filter: blur(5px);
        }

        .booking-form {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
        }

        .booking-form select, .booking-form input {
            padding: 10px;
            border: none;
            border-radius: 5px;
            width: 30%;
            font-size: 16px;
            background: rgba(255, 255, 255, 0.9);
        }

        .booking-form button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background: #0bbb5a;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .booking-form button:hover {
            background: #1e8a08;
        }

        /* Bus List */
        .bus-list {
            padding: 30px 5%;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .bus-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 700px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: 0.3s ease-in-out;
        }

        .bus-card:hover {
            transform: scale(1.02);
        }

        .bus-info {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .bus-info h3 {
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }

        .bus-info p {
            font-size: 14px;
            color: #555;
        }

        .bus-time {
            font-weight: bold;
            color: #1e8a08;
        }

        .bus-price {
            font-size: 18px;
            font-weight: bold;
            color: #0bbb5a;
        }

        .select-seat {
            background: #1e8a08;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .select-seat:hover {
            background: #08963e;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .booking-form select, .booking-form input {
                width: 100%;
            }

            .bus-card {
                flex-direction: column;
                text-align: center;
                padding: 20px;
            }

            .bus-price {
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>

<!-- Navigation -->
<nav>
    <div class="logo">
        <img src="image/logo.png" alt="Logo" />
    </div>
    <div class="links">
        <div class="link"><a href="home.php">Home</a></div>
        <div class="link"><a href="Bustime.php">Bus Timetables</a></div>
        <div class="link"><a href="service.php">Service</a></div>
        <div class="link"><a href="gallery.php">Gallery</a></div>
        <div class="link"><a href="contact_us.php">Contact</a></div>
    </div>
    <div class="buttons">
            <button data-aos="fade-up" data-aos-duration="1200" data-aos-delay="7000"><a href="userlogin.php">Login and Cancelation Policy</a></button>
        </div>
</nav>
<!-- Search Form Same Style as Home -->
<section class="booking-section">
    <div class="booking-container">
        <h2>The simplest way to book your bus tickets in Sri Lanka</h2>
        <form id="busForm" action="Busshedule.php" method="POST" class="booking-form">
            <!-- Dynamic Departure -->
            <select id="pickup" name="pickup_point" required>
                <option value="" disabled selected>Enter your departure station</option>
                <?php
                $departure_result = $conn->query($departure_query);
                while ($row = $departure_result->fetch_assoc()): ?>
                    <option value="<?= htmlspecialchars($row['via_city']); ?>" <?= ($selected_pickup == $row['via_city']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($row['via_city']); ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <!-- Dynamic Arrival -->
            <select id="drop" name="drop_point" required>
                <option value="" disabled selected>Enter your arrival station</option>
                <?php
                $arrival_result = $conn->query($arrival_query);
                while ($row = $arrival_result->fetch_assoc()): ?>
                    <option value="<?= htmlspecialchars($row['destination']); ?>" <?= ($selected_drop == $row['destination']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($row['destination']); ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <!-- Journey Date -->
            <input type="date" name="date" value="<?= $selected_date ?>" required>

            <button type="submit">Find Buses</button>
        </form>
    </div>
</section>

<!-- Show Available Buses -->
<div class="bus-list">
    <?php if (!empty($sqldata)): ?>
        <?php foreach ($sqldata as $row): ?>
            <div class="bus-card">
                <div class="bus-info">
                    <h3><?= $row['bus_name']; ?> - <?= $row['via_city']; ?> to <?= $row['destination']; ?></h3>
                    <p>Departure Date: <?= date("M d, Y", strtotime($row['schedule_date'])); ?></p>
                    <p>Departure Time: <span class="bus-time"><?= date("g:i A", strtotime($row['schedule_time'])); ?></span></p>
                </div>
                <div class="bus-price">Rs <?= number_format($row['cost'], 2); ?></div>
                <form action="seat_selection.php" method="POST">
                    <input type="hidden" name="via_city" value="<?= $row['via_city']; ?>">
                    <input type="hidden" name="destination" value="<?= $row['destination']; ?>">
                    <input type="hidden" name="date" value="<?= $row['schedule_date']; ?>">
                    <input type="hidden" name="time" value="<?= $row['schedule_time']; ?>">
                    <button type="submit" class="select-seat">Select Seat</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <p style="text-align: center; padding: 20px; color: red;">No buses found for the selected route and date.</p>
    <?php endif; ?>
</div>

</body>
</html>
