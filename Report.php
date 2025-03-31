<?php
session_start();
include("connection.php");

$from_date = $_GET['from_date'] ?? '';
$to_date = $_GET['to_date'] ?? '';
$route = $_GET['route'] ?? '';
$status = $_GET['status'] ?? '';

$sql = "SELECT * FROM passengers WHERE 1=1";
if ($from_date) $sql .= " AND journey_date >= '" . $conn->real_escape_string($from_date) . "'";
if ($to_date) $sql .= " AND journey_date <= '" . $conn->real_escape_string($to_date) . "'";
if ($route) $sql .= " AND bus_route = '" . $conn->real_escape_string($route) . "'";
if ($status !== '') $sql .= " AND is_canceled = '" . intval($status) . "'";
$result = $conn->query($sql);

$total_bookings = 0;
$total_seats = 0;
$total_sales = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Report</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ecf0f1;
            display: flex;
        }
        .sidebar {
            width: 260px;
            background: #2c3e50;
            color: white;
            height: 100vh;
            padding-top: 20px;
            position: fixed;
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 4px 0px 10px rgba(0, 0, 0, 0.2);
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
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
            width: 100%;
        }
        .sidebar ul li a {
            display: block;
            padding: 14px 25px;
            color: white;
            font-size: 16px;
            text-decoration: none;
        }
        .sidebar ul li a:hover {
            background: #1abc9c;
            padding-left: 35px;
        }
        .main-content {
            margin-left: 270px;
            padding: 30px;
            width: calc(100% - 270px);
        }
        h2 {
            margin-bottom: 20px;
            color: #2c3e50;
            font-weight: bold;
        }
        .filter-form {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: flex-end;
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .filter-form input,
        .filter-form select {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            min-width: 180px;
        }
        .filter-form button {
            padding: 8px 16px;
            background-color: #27ae60;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .table-container {
            margin-top: 25px;
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #2c3e50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .summary {
            margin-top: 20px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
        }
    </style>
</head>
<body>
<div class="sidebar">
    <header>
        <img src="image/avatar.png" alt="Admin Profile">
        <p>Admin Panel</p>
    </header>
    <ul>
        <li><a href="adminDashboard.php">Dashboard</a></li>
        <li><a href="adminDash.php">Manage Routes</a></li>
        <li><a href="route_schedule.php">Manage route Schedule</a></li>
        <li><a href="ManagesBuses.php">Manage Buses</a></li>
        <li><a href="admin_seat_selection.php">Booking People</a></li>
        <li><a href="admindetails.php">Passenger Confirmation</a></li>
        <li><a href="adminpayment.php">Transaction</a></li>
        <li><a href="Report.php">Generate Report</a></li>
        <li><a href="adminLogout.php">Logout</a></li>
    </ul>
</div>
<div class="main-content">
    <h2>Booking Report</h2>
    <form class="filter-form" method="GET">
        <input type="date" name="from_date" placeholder="From Date" value="<?= $from_date ?>">
        <input type="date" name="to_date" placeholder="To Date" value="<?= $to_date ?>">
        <input type="text" name="route" placeholder="e.g. Galle ➔ Colombo" value="<?= $route ?>">
        <select name="status">
            <option value="">All Status</option>
            <option value="0" <?= $status==='0' ? 'selected' : '' ?>>Booked</option>
            <option value="1" <?= $status==='1' ? 'selected' : '' ?>>Cancelled</option>
        </select>
        <button type="submit">Filter</button>
    </form>

    <div class="summary">
        <h5>Summary</h5>
        <?php foreach ($result as $row): 
            $total_bookings++;
            $total_sales += $row['total_price'];
            $total_seats += count(explode(',', $row['seats']));
        endforeach; ?>
        <p>Total Bookings: <?= $total_bookings ?></p>
        <p>Total Seats: <?= $total_seats ?></p>
        <p>Total Sales: Rs <?= number_format($total_sales, 2) ?></p>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Route</th>
                    <th>Seats</th>
                    <th>Date</th>
                    <th>Departure</th>
                    <th>Arrival</th>
                    <th>Gender</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Booked At</th>
                </tr>
            </thead>
            <tbody>
            <?php $result = $conn->query($sql); while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['mobile']) ?></td>
                    <td><?= htmlspecialchars($row['bus_route']) ?></td>
                    <td><?= $row['seats'] ?></td>
                    <td><?= $row['journey_date'] ?></td>
                    <td><?= $row['departure'] ?></td>
                    <td><?= $row['arrival'] ?></td>
                    <td><?= ucfirst($row['gender']) ?></td>
                    <td>Rs <?= number_format($row['total_price'], 2) ?></td>
                    <td><?= $row['is_canceled'] ? 'Cancelled' : 'Booked' ?></td>
                    <td><?= $row['created_at'] ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        <form method="post" action="generate_pdf.php" target="_blank">
    <button class="btn btn-danger">📄 Download PDF Report</button>
</form>

    </div>
</div>
</body>
</html>
