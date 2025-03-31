<?php 
session_start();
include("connection.php"); 


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Panel of Bus Services</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
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

    <div class="sidebar2">
        <h1>Manage Route of Buses</h1>
        <button class="btn" onclick="document.getElementById('addRouteModal').style.display='block'">Add Route</button>

        <table id="routeTable">
    <tr>
        <th>ID</th>
        <th>Via City</th>
        <th>Destination</th>
        <th>Bus Name</th>
        <th>Departure Date</th>
        <th>Departure Time</th>
        <th>Cost</th>
        <th>Update</th>
        <th>Delete</th>
    </tr>
    <?php
    $sqlget = "SELECT * FROM route";
    $sqldata = mysqli_query($conn, $sqlget);
    while ($row = mysqli_fetch_assoc($sqldata)) {
        $rowJson = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['via_city']}</td>
                <td>{$row['destination']}</td>
                <td>{$row['bus_name']}</td>
                <td>{$row['departure_date']}</td>
                <td>{$row['departure_time']}</td>
                <td>Rs {$row['cost']}</td>
                <td><button class='update-btn' onclick='openUpdateModal({$rowJson})'>Update</button></td>
                <td><button class='delete-btn' onclick='confirmDelete({$row['id']})'>Delete</button></td>
              </tr>";
    }
    ?>
</table>

    </div>

<!-- Add Route Modal -->
<div id="addRouteModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="document.getElementById('addRouteModal').style.display='none'">&times;</span>
        <h2>Add New Route</h2>
        <form id="addRouteForm" action="Addroute.php" method="POST">
            <input type="text" name="via_city" placeholder="Via City" required>
            <input type="text" name="destination" placeholder="Destination" required>
            <input type="text" name="bus_name" placeholder="Bus Name" required>
            <input type="date" name="departure_date" required>
            <input type="time" name="departure_time" required>
            <input type="text" name="cost" placeholder="Cost" required>
            <button type="submit" class="btn">Add Route</button>
        </form>
    </div>
</div>


<!-- Update Route Modal -->
<div id="updateRouteModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="document.getElementById('updateRouteModal').style.display='none'">&times;</span>
        <h2>Update Route</h2>
        <form id="updateRouteForm" action="updateRoute.php" method="POST">
            <input type="hidden" id="update_id" name="id">
            <input type="text" id="update_via_city" name="via_city" required>
            <input type="text" id="update_destination" name="destination" required>
            <input type="text" id="update_bus_name" name="bus_name" required>
            <input type="date" id="update_departure_date" name="departure_date" required>
            <input type="time" id="update_departure_time" name="departure_time" required>
            <input type="text" id="update_cost" name="cost" required>
            <button type="submit" class="btn">Update Route</button>
        </form>
    </div>
</div>


    <script>
   function openUpdateModal(route) {
    document.getElementById('updateRouteModal').style.display = 'block';
    document.getElementById('update_id').value = route.id;
    document.getElementById('update_via_city').value = route.via_city;
    document.getElementById('update_destination').value = route.destination;
    document.getElementById('update_bus_name').value = route.bus_name;
    document.getElementById('update_departure_date').value = route.departure_date;
    document.getElementById('update_departure_time').value = route.departure_time;
    document.getElementById('update_cost').value = route.cost;
}

function confirmDelete(id) {
    if (confirm("Are you sure you want to delete this route?")) {
        window.location.href = 'deleteRoute.php?id=' + id;
    }
}

    </script>


</body>
</html>
