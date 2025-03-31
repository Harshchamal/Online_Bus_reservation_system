<?php 
session_start();
include("connection.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - Manage Buses</title>
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

        .sidebar ul li a {
            display: block;
            padding: 14px 25px;
            color: white;
            font-size: 16px;
            text-decoration: none;
            transition: 0.3s;
        }

        .sidebar ul li a:hover {
            background: #1abc9c;
            padding-left: 30px;
        }

        /* Content Section */
        .content {
            margin-left: 270px;
            padding: 20px;
            width: calc(100% - 270px);
        }

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
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        /* Buttons */
        .btn {
            border: none;
            padding: 10px 14px;
            cursor: pointer;
            color: white;
            font-weight: bold;
            border-radius: 5px;
        }

        .update-btn { background-color: #3498db; }
        .delete-btn { background-color: #e74c3c; }
        .add-btn { background: #27ae60; margin-bottom: 20px; }

        .btn:hover { opacity: 0.8; }

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

        .modal-content input {
            width: 90%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .close {
            float: right;
            font-size: 22px;
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

    <div class="content">
        <h1 class="adminTopic">Manage Buses</h1>

        <button class="btn add-btn" onclick="document.getElementById('addBusModal').style.display='block'">Add Bus</button>

        <?php
        $sqlget = "SELECT * FROM bus";
        $sqldata = mysqli_query($conn, $sqlget) or die('Error retrieving data');

        echo "<table>";
        echo "<tr>
                <th>ID</th>
                <th>Bus Number</th>
                <th>Conductor Number</th>
                <th>Update</th>
                <th>Delete</th>
              </tr>";

        while ($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)) {
            $rowJson = htmlspecialchars(json_encode([
                "id" => $row['id'],
                "bus_number" => $row['bus_number'],
                "conductor_number" => $row['conductor_number']
            ]), ENT_QUOTES, 'UTF-8');

            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['bus_number']}</td>
                    <td>{$row['conductor_number']}</td>
                    <td><button class='update-btn btn' onclick='openUpdateBusModal({$rowJson})'>Update</button></td>
                    <td><button class='delete-btn btn' onclick='confirmDelete({$row['id']})'>Delete</button></td>
                  </tr>";
        }
        echo "</table>";
        ?>

        <!-- Add Modal -->
        <div id="addBusModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="document.getElementById('addBusModal').style.display='none'">&times;</span>
                <h2>Add New Bus</h2>
                <form action="AddtimetabelBus.php" method="POST">
                     <input type="text" name="bus_number" placeholder="Bus Number" required>
                     <input type="text" name="conductor_number" placeholder="Conductor Number" required>
                     <button type="submit" class="btn add-btn">Add Bus</button>
                     </form>

               </div>
            </div>

        <!-- Update Modal -->
        <div id="updateBusModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="document.getElementById('updateBusModal').style.display='none'">&times;</span>
                <h2>Update Bus</h2>
                <form action="updateBus.php" method="POST">
                    <input type="hidden" id="update_id" name="id">
                    <input type="text" id="update_bus_number" name="bus_number" required placeholder="Bus Number">
                    <input type="text" id="update_conductor_number" name="conductor_number" required placeholder="Conductor Number">
                    <button type="submit" class="btn update-btn">Update Bus</button>
                </form>
            </div>
        </div>

        <script>
        function openUpdateBusModal(bus) {
            document.getElementById('updateBusModal').style.display = 'block';
            document.getElementById('update_id').value = bus.id;
            document.getElementById('update_bus_number').value = bus.bus_number;
            document.getElementById('update_conductor_number').value = bus.conductor_number;
        }

        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this bus?")) {
                window.location.href = 'deleteBus.php?id=' + id;
            }
        }
        </script>
    </div>
</body>
</html>