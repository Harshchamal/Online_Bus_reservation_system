<?php 
include("connection.php");

// Fetch all booked seats
$result = $conn->query("SELECT * FROM bookings ORDER BY journey_date DESC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Seat Bookings</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

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
.main-content {
    margin-left: 270px;
    padding: 20px;
    width: calc(100% - 270px);
}

/* Admin Panel Title */
.adminTopic {
    text-align: center;
    font-size: 28px;
    margin-bottom: 20px;
    font-weight: bold;
    color: #34495e;
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
    font-size: 16px;
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

/* Update Modal */
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
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.close-btn {
    float: right;
    font-size: 20px;
    cursor: pointer;
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

/* Responsive Design */
@media (max-width: 992px) {
    .sidebar {
        width: 220px;
    }
    .main-content {
        margin-left: 230px;
    }
    .adminTopic {
        font-size: 24px;
    }
    th, td {
        font-size: 14px;
        padding: 10px;
    }
    td button {
        padding: 8px 10px;
    }
}

@media (max-width: 768px) {
    .sidebar {
        width: 200px;
    }
    .main-content {
        margin-left: 210px;
        padding: 15px;
    }
    .adminTopic {
        font-size: 20px;
    }
    th, td {
        font-size: 13px;
        padding: 8px;
    }
    td button {
        padding: 6px 8px;
    }
    .modal-content {
        width: 80%;
    }
}

@media (max-width: 576px) {
    .sidebar {
        width: 180px;
    }
    .main-content {
        margin-left: 190px;
        padding: 10px;
    }
    .adminTopic {
        font-size: 18px;
    }
    th, td {
        font-size: 12px;
        padding: 6px;
    }
    td button {
        padding: 5px 6px;
    }
    .modal-content {
        width: 90%;
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
        <h2 class="adminTopic">Admin - Seat Bookings</h2>

        <div class="table-container">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Passenger ID</th>
                            <th>Seats</th>
                            <th>Status</th>
                            <th>Gender</th>
                            <th>Journey Date</th>
                            <th>Departure</th>
                            <th>Arrival</th>
                            <th>Total Price</th>
                            <th>Bus Route</th>
                            <th>Created At</th>
                            <th>Action</th>
                         </tr>
                </thead>
                <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                           <tr>
                            <td><?= $row['id']; ?></td>
                               <td><?= $row['passenger_id']; ?></td>
                               <td><?= $row['seats']; ?></td>
                               <td><?= $row['status']; ?></td>
                               <td><?= $row['gender']; ?></td>
                               <td><?= $row['journey_date']; ?></td>
                               <td><?= $row['departure']; ?></td>
                               <td><?= $row['arrival']; ?></td>
                               <td>Rs <?= $row['total_price']; ?></td>
                               <td><?= $row['bus_route']; ?></td>
                               <td><?= $row['created_at']; ?></td>
                               <td>
                                 <button class="btn btn-primary update-btn" data-id="<?= $row['id']; ?>">Update</button>
                                 <button class="btn btn-danger delete-btn" data-id="<?= $row['id']; ?>">Cancel</button>
                              </td>
                           </tr>
                      <?php endwhile; ?>

                </tbody>
            </table>
        </div>
    </div>

    <div id="updateModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h3>Update Booking</h3>
            <form id="updateForm">
                <input type="hidden" id="updateId">
                <label>Journey Date:</label>
                <input type="date" id="updateDate" class="form-control">
                <label>Departure:</label>
                <input type="text" id="updateDeparture" class="form-control">
                <label>Arrival:</label>
                <input type="text" id="updateArrival" class="form-control">
                <button type="submit" class="btn btn-success">Save Changes</button>
            </form>
        </div>
    </div>

    <script>
        document.querySelectorAll(".delete-btn").forEach(button => {
            button.addEventListener("click", function () {
                let bookingId = this.getAttribute("data-id");

                if (confirm("Are you sure you want to cancel this booking?")) {
                    fetch("seat_delete_booking.php", {
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

        document.querySelectorAll(".update-btn").forEach(button => {
            button.addEventListener("click", function () {
                let bookingId = this.getAttribute("data-id");

                fetch(`get_booking.php?id=${bookingId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById("updateId").value = data.booking.id;
                            document.getElementById("updateDate").value = data.booking.journey_date;
                            document.getElementById("updateDeparture").value = data.booking.departure;
                            document.getElementById("updateArrival").value = data.booking.arrival;
                            document.getElementById("updateModal").style.display = "block";
                        } else {
                            alert("Error fetching booking details.");
                        }
                    })
                    .catch(error => console.error("Error:", error));
            });
        });

        document.querySelector(".close-btn").addEventListener("click", function () {
            document.getElementById("updateModal").style.display = "none";
        });

        document.getElementById("updateForm").addEventListener("submit", function (event) {
            event.preventDefault();

            let bookingId = document.getElementById("updateId").value;
            let journeyDate = document.getElementById("updateDate").value;
            let departure = document.getElementById("updateDeparture").value;
            let arrival = document.getElementById("updateArrival").value;

            fetch("update_booking.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    id: bookingId,
                    journey_date: journeyDate,
                    departure: departure,
                    arrival: arrival
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
    </script>

</body>
</html>

<?php $conn->close(); ?>
