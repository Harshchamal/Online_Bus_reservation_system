<?php
session_start();
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $name = trim($_POST['name']);
    $id_number = trim($_POST['id_number']);

    // Convert name to lowercase for case-insensitive comparison
    $query = "SELECT id, name, id_number FROM passengers WHERE LOWER(name) = LOWER(?) AND id_number = ? LIMIT 1";
    
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("ss", $name, $id_number);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user exists
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $_SESSION['passenger_id'] = $user['id']; 
            $_SESSION['name'] = $user['name'];  
            $_SESSION['id_number'] = $user['id_number'];  
            header("Location: dashboard.php"); 
            exit();
        } else {
            echo "<script>alert('User not found. Please check your Name and NIC and try again.');</script>";
        }
    } else {
        echo "<script>alert('Database error. Please try again later.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* General Styling */
        body {
    font-family: 'Arial', sans-serif;
    background: linear-gradient(rgba(43, 38, 38, 0.85), rgba(9, 179, 51, 0.85)), 
                url('image/10.jpg');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}
        .login-box {
            width: 400px;
            background: rgba(255, 255, 255, 0.9);
            padding: 40px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: center;
        }
        .avatar {
            width: 100px;
            margin-bottom: 20px;
        }
        h1 {
            margin-bottom: 20px;
            font-size: 22px;
            color: #333;
        }
        .login-box p {
            font-weight: bold;
            color: #555;
            text-align: left;
        }
        .form-control {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        .btn-login {
            background: #1e8a08;
            color: white;
            font-weight: bold;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .btn-login:hover {
            background: #166506;
        }

        /* Aligning the Admin & Home links */
        .login-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 15px;
        }
        .login-links a {
            color: #1e8a08;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            transition: color 0.3s ease;
        }
        .login-links a:hover {
            text-decoration: underline;
            color: #166506;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <img src="image/avatar.png" class="avatar" alt="User Avatar">
        <h1>Login to Your Booking Dashboard</h1>

        <form method="POST">
            <p>UserName:</p>
            <input type="text" class="form-control" id="name" name="name" required>

            <p>NIC Number:</p>
            <input type="text" class="form-control" id="id_number" name="id_number" required>

            <button type="submit" class="btn-login">Login</button>
        </form>

        <!-- Cleaned and centered Admin & Home links -->
        <div class="login-links">
            <a href="adminLogin.php">Admin</a>
            <a href="home.php">Home</a>
        </div>
    </div>
</body>
</html>
