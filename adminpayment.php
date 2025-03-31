<?php
session_start();
include("connection.php");

// Fetch all payment details
$result = $conn->query("SELECT * FROM payments ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Payment Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        /* General Styling */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ecf0f1;
            display: flex;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 260px;
            background: #2c3e50;
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
            background: #1abc9c;
            border-left: 4px solid white;
            padding-left: 30px;
        }

        /* Main Content */
        .main-content {
            margin-left: 270px;
            padding: 20px;
            flex-grow: 1;
            width: calc(100% - 270px);
        }

        /* Table Styling */
        .table-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            text-align: center;
            padding: 12px;
            font-size: 14px;
        }

        th {
            background: #2c3e50;
            color: white;
            font-weight: bold;
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 14px;
            cursor: pointer;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }
            .main-content {
                margin-left: 210px;
                padding: 15px;
            }
            table {
                font-size: 12px;
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

    <!-- Main Content -->
    <div class="main-content">
        <h2 class="text-center">Admin - Payment Management</h2>

        <div class="table-container">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Passenger ID</th>
                        <th>Amount (Rs)</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>Zip Code</th>
                        <th>Name on Card</th>
                        <th>Card Number</th>
                        <th>Exp Month</th>
                        <th>Exp Year</th>
                        <th>CVV</th>
                        <th>Payment Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['passenger_id']; ?></td>
            <td><?= $row['amount']; ?></td>
            <td><?= $row['name']; ?></td>
            <td><?= $row['email']; ?></td>
            <td><?= isset($row['address']) ? $row['address'] : 'N/A'; ?></td>
            <td><?= isset($row['city']) ? $row['city'] : 'N/A'; ?></td>
            <td><?= isset($row['zip']) ? $row['zip'] : 'N/A'; ?></td>
            <td><?= isset($row['card_name']) ? $row['card_name'] : 'N/A'; ?></td>
            <td><?= isset($row['card_number']) ? '**** **** **** ' . substr($row['card_number'], -4) : 'N/A'; ?></td>
            <td><?= isset($row['exp_month']) ? $row['exp_month'] : '--'; ?></td>
            <td><?= isset($row['exp_year']) ? $row['exp_year'] : '--'; ?></td>
            <td>***</td>
            <td>
                <select class="form-select status-update" data-id="<?= $row['id']; ?>">
                    <option value="Completed" <?= ($row['payment_status'] == 'Completed') ? 'selected' : ''; ?>>Completed</option>
                    <option value="Pending" <?= ($row['payment_status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                    <option value="Refund" <?= ($row['payment_status'] == 'Refund') ? 'selected' : ''; ?>>Refund</option>
                </select>
            </td>
            <td>
                <button class="btn btn-danger btn-sm delete-payment" data-id="<?= $row['id']; ?>">Delete</button>
            </td>
        </tr>
    <?php endwhile; ?>
</tbody>
            </table>
        </div>
    </div>

    <script>
        document.querySelectorAll('.status-update').forEach(select => {
            select.addEventListener('change', function () {
                let paymentId = this.getAttribute("data-id");
                let newStatus = this.value;

                fetch('update_payment_status.php', {
                    method: 'POST',
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ id: paymentId, status: newStatus })
                }).then(response => response.json())
                .then(data => alert(data.message))
                .catch(error => console.error('Error:', error));
            });
        });
    </script>

</body>
</html>
