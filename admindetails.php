<?php
session_start();
include("connection.php");

// Fetch all passengers
$result = $conn->query("SELECT * FROM passengers ORDER BY journey_date DESC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Passengers</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
      /* General Page Styling */
      body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            display: flex;
        }

        /* Sidebar */
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

        .sidebar header {
            text-align: center;
            padding-bottom: 20px;
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
            width: calc(100% - 270px);
        }

        .table-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            text-align: center;
            padding: 12px;
        }

        th {
            background: #2c3e50;
            color: white;
        }

        .btn-container {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        /* Buttons */
        .btn-danger, .btn-primary {
            font-size: 14px;
            padding: 5px 10px;
            cursor: pointer;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 20px;
            width: 50%;
            border-radius: 8px;
            text-align: center;
        }

        .close-btn {
            float: right;
            font-size: 20px;
            cursor: pointer;
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
        <h2 class="text-center">Admin - Manage Passengers</h2>

        <div class="table-container">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>NIC/Passport</th>
                        <th>Email</th>
                        <th>Seats</th>
                        <th>Journey Date</th>
                        <th>Departure</th>
                        <th>Arrival</th>
                        <th>Total Price (Rs)</th>
                        <th>Booking Time</th>
                        <th>Cancellation Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id']; ?></td>
                            <td><?= $row['name']; ?></td>
                            <td><?= $row['mobile']; ?></td>
                            <td><?= $row['id_number']; ?></td>
                            <td><?= $row['email']; ?></td>
                            <td><?= $row['seats']; ?></td>
                            <td><?= $row['journey_date']; ?></td>
                            <td><?= $row['departure']; ?></td>
                            <td><?= $row['arrival']; ?></td>
                            <td><?= $row['total_price']; ?></td>
                            <td><?= isset($row['booking_time']) ? $row['booking_time'] : 'N/A'; ?></td>
                            <td><?= isset($row['cancellation_status']) ? ($row['cancellation_status'] ? 'Canceled' : 'Active') : 'Active'; ?></td>
                            <td class="btn-container">
                                <button class="btn btn-primary update-btn" data-id="<?= $row['id']; ?>">Update</button>
                                <button class="btn btn-danger delete-btn" data-id="<?= $row['id']; ?>">Delete</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Update Modal -->
    <div id="updateModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h3>Update Passenger</h3>
            <form id="updateForm">
                <input type="hidden" id="updateId">
                <label>Name:</label>
                <input type="text" id="updateName" class="form-control">
                <label>Mobile:</label>
                <input type="text" id="updateMobile" class="form-control">
                <label>Email:</label>
                <input type="email" id="updateEmail" class="form-control">
                <button type="submit" class="btn btn-success">Save Changes</button>
            </form>
        </div>
    </div>

    <script>
        // Handle Update Button Click
        document.querySelectorAll(".update-btn").forEach(button => {
            button.addEventListener("click", function () {
                let bookingId = this.getAttribute("data-id");

                fetch(`get_passenger.php?id=${bookingId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById("updateId").value = data.passenger.id;
                            document.getElementById("updateName").value = data.passenger.name;
                            document.getElementById("updateMobile").value = data.passenger.mobile;
                            document.getElementById("updateEmail").value = data.passenger.email;
                            document.getElementById("updateModal").style.display = "block";
                        } else {
                            alert("Error fetching passenger details.");
                        }
                    })
                    .catch(error => console.error("Error:", error));
            });
        });

        document.querySelector(".close-btn").addEventListener("click", function () {
            document.getElementById("updateModal").style.display = "none";
        });

        // Handle Update Form Submission
        document.getElementById("updateForm").addEventListener("submit", function (event) {
            event.preventDefault();

            fetch("update_passenger.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    id: document.getElementById("updateId").value,
                    name: document.getElementById("updateName").value,
                    mobile: document.getElementById("updateMobile").value,
                    email: document.getElementById("updateEmail").value
                })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => console.error("Error:", error));
        });

        // Handle Delete Button Click
        document.querySelectorAll(".delete-btn").forEach(button => {
            button.addEventListener("click", function () {
                let bookingId = this.getAttribute("data-id");

                if (confirm("Are you sure you want to delete this passenger?")) {
                    fetch("delete_passenger.php", {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ id: bookingId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        if (data.success) {
                            location.reload();
                        }
                    })
                    .catch(error => console.error("Error:", error));
                }
            });
        });
    </script>

</body>
</html>
