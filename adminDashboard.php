<?php
session_start();
include("connection.php");

// Count stats from the DB
$customers = $conn->query("SELECT COUNT(*) as total FROM passengers")->fetch_assoc()['total'] ?? 0;
$bookings = $conn->query("SELECT COUNT(*) as total FROM bookings")->fetch_assoc()['total'] ?? 0;
$buses = $conn->query("SELECT COUNT(*) as total FROM bus")->fetch_assoc()['total'] ?? 0;
$seats = $conn->query("SELECT SUM(CHAR_LENGTH(seats) - CHAR_LENGTH(REPLACE(seats, ',', '')) + 1) as total FROM bookings WHERE status='booked'")->fetch_assoc()['total'] ?? 0;
$routes = $conn->query("SELECT COUNT(*) as total FROM route")->fetch_assoc()['total'] ?? 0;
$availability = $conn->query("SELECT COUNT(*) as total FROM route_schedule")->fetch_assoc()['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
     /* General Styling */
     body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #ecf0f1;
    display: flex;
    min-height: 100vh;
}

/* Sidebar Styling */
.sidebar {
    width: 260px;
    background: #2c3e50; /* Dark blue */
    color: white;
    height: 100vh;
    padding-top: 20px;
    position: fixed;
    left: 0;
    top: 0;
    transition: 0.3s;
    display: flex;
    flex-direction: column;
    align-items: center;
    box-shadow: 4px 0px 10px rgba(0, 0, 0, 0.2);
}

/* User Profile Section */
.sidebar header {
    text-align: center;
    padding-bottom: 20px;
    width: 100%;
}

.sidebar header img {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    border: 3px solid white;
    margin-bottom: 10px;
}

.sidebar header p {
    font-weight: bold;
    font-size: 18px;
    color: #ecf0f1;
    margin: 0;
}

/* Sidebar Navigation */
.sidebar ul {
    list-style: none;
    padding: 0;
    width: 100%;
}

.sidebar ul li {
    width: 100%;
    text-align: left;
}

.sidebar ul li a {
    display: block;
    padding: 14px 25px;
    color: white;
    font-size: 16px;
    text-decoration: none;
    font-weight: 500;
    transition: 0.3s;
    border-left: 4px solid transparent;
}

.sidebar ul li a:hover {
    background: #1abc9c; /* Greenish color */
    border-left: 4px solid white;
    padding-left: 30px;
}

/* Main Content */
.sidebar2 {
    margin-left: 270px;
    padding: 20px;
    flex-grow: 1;
    width: 100%;
}

/* Admin Panel Title */
.adminTopic {
    text-align: center;
    font-size: 26px;
    margin-bottom: 20px;
    font-weight: bold;
    color: #34495e;
}

/* Table Styling */
table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

table, th, td {
    border: 1px solid #ddd;
    text-align: center;
    padding: 12px;
}

th {
    background: #2c3e50;
    color: white;
    font-weight: bold;
}

td {
    background: #ffffff;
}

tr:nth-child(even) {
    background-color: #f8f9fa;
}

/* Buttons */
td button {
    border: none;
    padding: 10px 14px;
    cursor: pointer;
    color: white;
    font-weight: bold;
    border-radius: 5px;
    transition: 0.3s;
}

td button a {
    color: white;
    text-decoration: none;
}

td button:hover {
    opacity: 0.8;
}

.update-btn {
    background-color: #3498db; /* Blue */
}

.delete-btn {
    background-color: #e74c3c; /* Red */
}

/* Add Route Button */
.btnPolicy {
    display: inline-block;
    text-align: center;
    margin: 20px auto;
    padding: 12px 20px;
    font-size: 16px;
    background: #27ae60; /* Green */
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
    text-decoration: none;
}

.btnPolicy:hover {
    background: #218c54;
}

.btnPolicy a {
    color: white;
    text-decoration: none;
    display: block;
    width: 100%;
    height: 100%;
}

/* Modal Styling */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
}

.modal-content {
    background-color: white;
    padding: 20px;
    margin: 10% auto;
    width: 40%;
    border-radius: 8px;
    text-align: center;
}

.close {
    float: right;
    font-size: 22px;
    cursor: pointer;
}

.modal-content input, .modal-content select {
    width: 90%;
    padding: 10px;
    margin: 8px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}
/* Buttons */
.btn {
    display: inline-block;
    padding: 12px 20px;
    font-size: 16px;
    background: #27ae60;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

.btn:hover {
    background: #218c54;
}



/* Responsive Design */
@media (max-width: 768px) {
    .sidebar {
        width: 200px;
    }
    .sidebar2 {
        margin-left: 210px;
        padding: 15px;
    }
    .adminTopic {
        font-size: 20px;
    }
    table, th, td {
        font-size: 14px;
        padding: 8px;
    }
    td button {
        padding: 6px 10px;
    }
}
/* Dashboard Card Grid */
.main-content {
    margin-left: 270px;
    padding: 30px;
    width: calc(100% - 270px);
}

.dashboard-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

/* Individual Card Styles */
.card {
    background-color: #ffffff;
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: all 0.3s ease-in-out;
}

.card:hover {
    transform: translateY(-5px);
}

.card h3 {
    font-size: 24px;
    margin: 10px 0 5px;
}

.card p {
    font-size: 16px;
    margin: 0;
    opacity: 0.9;
}

/* Icon Styles */
.card .icon {
    font-size: 36px;
    margin-bottom: 10px;
}

/* Card Color Themes */
.card.red { background-color: #e74c3c; color: white; }
.card.orange { background-color: #f39c12; color: white; }
.card.green { background-color: #27ae60; color: white; }
.card.blue { background-color: #3498db; color: white; }
.card.check { background-color: #9b59b6; color: white; }

/* Responsive Adjustments */
@media (max-width: 768px) {
    .dashboard-cards {
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    }

    .main-content {
        margin-left: 220px;
        padding: 20px;
    }

    .card h3 {
        font-size: 20px;
    }

    .card .icon {
        font-size: 28px;
    }
}

    </style>
</head>
<body>


   <!-- Sidebar -->
   <div class="sidebar">
        <header>
        <img src="image/avatar.png" alt="Admin Profile">
            <p>Admin Panel</p>
            </header>
        <ul>
        <li><a href="adminDashboard.php">DashBored</a></li>
        <li><a href="adminDash.php">Manage Routes</a></li>
        <li><a href="route_schedule.php">Manage route Schedule</a></li>
        <li><a href="ManagesBuses.php">Manage Buses</a></li>
        <li><a href="admin_seat_selection.php">Booking People</a></li>
        <li><a href="admindetails.php">Passenger confirmation</a></li>
        <li><a href="adminpayment.php">Transaction</a></li>
        <li><a href="Report.php">Generete Report</a></li>
        <li><a href="adminLogout.php">Logout</a></li>
        </ul>
    </div>

<div class="main-content">
    <h1>Welcome <strong>admin</strong></h1>

    <div class="dashboard-cards">
        <div class="card red">
            <div class="icon"><i class="fa fa-users"></i></div>
            <h3><?= $customers ?></h3>
            <p>Customers</p>
        </div>
        <div class="card orange">
            <div class="icon"><i class="fa fa-ticket"></i></div>
            <h3><?= $bookings ?></h3>
            <p>Bookings</p>
        </div>
        <div class="card green">
            <div class="icon"><i class="fa fa-calendar"></i></div>
            <h3><?= date("D / M / d / Y") ?></h3>
            <p>Today</p>
        </div>
        <div class="card blue">
            <div class="icon"><i class="fa fa-user"></i></div>
            <h3>Admin</h3>
            <p>Account</p>
        </div>
        <div class="card green">
            <div class="icon"><i class="fa fa-bus"></i></div>
            <h3><?= $buses ?></h3>
            <p>Buses</p>
        </div>
        <div class="card blue">
            <div class="icon"><i class="fa fa-th-large"></i></div>
            <h3><?= $seats ?></h3>
            <p>Booked Seats</p>
        </div>
        <div class="card check">
            <div class="icon"><i class="fa fa-check-circle"></i></div>
            <h3><?= $availability ?></h3>
            <p>Route Schedules</p>
        </div>
        <div class="card orange">
            <div class="icon"><i class="fa fa-road"></i></div>
            <h3><?= $routes ?></h3>
            <p>Routes</p>
        </div>
    </div>
</div>

</body>
</html>
