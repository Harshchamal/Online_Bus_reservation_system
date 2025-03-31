<?php
session_start();
include("connection.php");

// Add a single schedule entry
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_schedule'])) {
    $route_id = intval($_POST['route_id']);
    $schedule_date = $_POST['schedule_date'];
    $schedule_time = $_POST['schedule_time'];

    $stmt = $conn->prepare("INSERT INTO route_schedule (route_id, schedule_date, schedule_time) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $route_id, $schedule_date, $schedule_time);
    $stmt->execute();
    header("Location: route_schedule.php");
    exit();
}

// Add 20 schedule entries starting from a base date
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generate_20_days'])) {
    $route_id = intval($_POST['route_id']);
    $start_date = new DateTime($_POST['start_date']);
    $time = $_POST['schedule_time'];

    for ($i = 0; $i < 20; $i++) {
        $next_date = clone $start_date;
        $next_date->modify("+$i day");
        $schedule_date = $next_date->format('Y-m-d');

        $stmt = $conn->prepare("INSERT INTO route_schedule (route_id, schedule_date, schedule_time) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $route_id, $schedule_date, $time);
        $stmt->execute();
    }

    header("Location: route_schedule.php");
    exit();
}

// Delete schedule
if (isset($_GET['delete_schedule'])) {
    $id = intval($_GET['delete_schedule']);
    $conn->query("DELETE FROM route_schedule WHERE id = $id");
    header("Location: route_schedule.php");
    exit();
}

// Fetch all routes
$routes = $conn->query("SELECT * FROM route ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Route Schedule Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="cssfile/route_shedule.css">

    <style>
   /* ===== GLOBAL STYLES ===== */
body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f7fa;
    display: flex;
    min-height: 100vh;
}

/* ===== SIDEBAR ===== */
.sidebar {
    width: 260px;
    background: #2c3e50;
    color: #fff;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding-top: 20px;
    box-shadow: 4px 0 10px rgba(0, 0, 0, 0.15);
}

.sidebar header {
    text-align: center;
    padding-bottom: 20px;
    width: 100%;
}

.sidebar header img {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: 3px solid #fff;
    margin-bottom: 10px;
}

.sidebar header p {
    margin: 0;
    font-weight: bold;
    font-size: 18px;
}

.sidebar ul {
    list-style: none;
    padding: 0;
    width: 100%;
    margin-top: 20px;
}

.sidebar ul li a {
    display: block;
    padding: 14px 25px;
    color: #fff;
    font-size: 16px;
    text-decoration: none;
    transition: 0.3s;
}

.sidebar ul li a:hover {
    background-color: #1abc9c;
    padding-left: 35px;
}

/* ===== MAIN CONTAINER ===== */
.container {
    margin-left: 280px;
    padding: 30px;
    width: 100%;
    max-width: 1100px;
}

.container h2 {
    text-align: center;
    margin-bottom: 40px;
    font-size: 28px;
    color: #2c3e50;
}

/* ===== ROUTE BLOCK ===== */
.route-block {
    background: #ffffff;
    padding: 24px;
    border-radius: 12px;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    margin-bottom: 25px;
    transition: 0.3s ease;
    border-left: 4px solid #2980b9;
}

.route-block:hover {
    box-shadow: 0 5px 16px rgba(0, 0, 0, 0.08);
}

.route-block h3 {
    margin: 0 0 15px;
    font-size: 20px;
    color: #2c3e50;
    display: flex;
    align-items: center;
    gap: 10px;
}

.route-block h3 i {
    color: #3498db;
}

/* ===== BUTTONS ===== */
.dropdown-toggle {
    background: #2980b9;
    color: white;
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-bottom: 15px;
}

.add-btn,
.generate-btn,
.delete-btn {
    padding: 10px 16px;
    font-size: 14px;
    font-weight: 500;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    transition: 0.3s;
}

.add-btn {
    background-color: #2ecc71;
    color: white;
}

.add-btn:hover {
    background-color: #27ae60;
}

.generate-btn {
    background-color: #3498db;
    color: white;
}

.generate-btn:hover {
    background-color: #2980b9;
}

.delete-btn {
    background-color: #e74c3c;
    color: white;
    text-decoration: none;
    display: inline-block;
}

.delete-btn:hover {
    background-color: #c0392b;
}

/* ===== FORMS ===== */
.route-block form {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
    flex-wrap: wrap;
}

.route-block form input[type="date"],
.route-block form input[type="time"] {
    padding: 10px 12px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 14px;
    background: #f9f9f9;
    transition: border-color 0.2s;
    width: 170px;
}

.route-block form input:focus {
    border-color: #2980b9;
    outline: none;
    background: #fff;
}

/* ===== SCHEDULE TABLE ===== */
.schedule-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    margin-top: 15px;
    border-radius: 8px;
    overflow: hidden;
    display: none;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.schedule-table th {
    background-color: #34495e;
    color: #ffffff;
    text-transform: uppercase;
    font-size: 14px;
    padding: 12px 10px;
    border-bottom: 2px solid #2c3e50;
}

.schedule-table td {
    padding: 12px 10px;
    font-size: 15px;
    background-color: #ffffff;
    color: #333;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

.schedule-table tr:nth-child(even) td {
    background-color: #f4f8fb;
}

.schedule-table tr:hover td {
    background-color: #e8f6ff;
    transition: background-color 0.3s ease;
}

/* ===== RESPONSIVE DESIGN ===== */
@media (max-width: 768px) {
    .container {
        padding: 20px;
        margin-left: 0;
    }

    .sidebar {
        position: relative;
        width: 100%;
        height: auto;
    }

    .sidebar ul {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }

    .route-block form {
        flex-direction: column;
        align-items: flex-start;
    }

    .route-block form input,
    .route-block form button {
        width: 100%;
        margin-bottom: 10px;
    }

    .schedule-table {
        font-size: 14px;
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

<div class="container">
    <h2>Manage Monthly Schedules for Routes</h2>

    <?php while ($route = $routes->fetch_assoc()): ?>
        <div class="route-block">
            <h3><?= $route['via_city']; ?> ➝ <?= $route['destination']; ?> (<?= $route['bus_name']; ?>)</h3>

            <!-- Toggle View -->
            <button class="dropdown-toggle" onclick="toggleSchedule(<?= $route['id']; ?>)">
                Show/Hide Schedule List
            </button>

            <!-- Schedule Table -->
            <table class="schedule-table" id="schedule-<?= $route['id']; ?>">
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Action</th>
                </tr>
                <?php
                    $schedules = $conn->query("SELECT * FROM route_schedule WHERE route_id = {$route['id']} ORDER BY schedule_date ASC");
                    while ($s = $schedules->fetch_assoc()):
                ?>
                <tr>
                    <td><?= $s['id']; ?></td>
                    <td><?= $s['schedule_date']; ?></td>
                    <td><?= $s['schedule_time']; ?></td>
                    <td><a class="delete-btn" href="?delete_schedule=<?= $s['id']; ?>" onclick="return confirm('Delete this schedule?');">Delete</a></td>
                </tr>
                <?php endwhile; ?>
            </table>

            <!-- Add One Date -->
            <form method="POST" style="margin-top:10px;">
                <input type="hidden" name="route_id" value="<?= $route['id']; ?>">
                <input type="date" name="schedule_date" required>
                <input type="time" name="schedule_time" required>
                <button type="submit" name="add_schedule" class="add-btn">Add Date</button>
            </form>

            <!-- Generate 20 Days -->
            <form method="POST" style="margin-top:10px;">
                <input type="hidden" name="route_id" value="<?= $route['id']; ?>">
                <input type="date" name="start_date" required>
                <input type="time" name="schedule_time" required>
                <button type="submit" name="generate_20_days" class="generate-btn">Generate 20 Days</button>
            </form>
        </div>
    <?php endwhile; ?>
</div>

<script>
        function toggleSchedule(routeId) {
            const table = document.getElementById('schedule-' + routeId);
            table.style.display = (table.style.display === 'none') ? 'table' : 'none';
        }
    </script>

</body>
</html>