<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Neelawala Express - Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(rgba(207, 238, 212, 0.85), rgba(164, 187, 170, 0.85)), url('image/nn.png');
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .registration_form {
            width: 450px;
            background: rgba(255, 255, 255, 0.9);
            padding: 40px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            text-align: center;
        }
        .registration_form .title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }
        .registration_form label {
            display: block;
            text-align: left;
            font-weight: bold;
            margin-top: 10px;
            color: #555;
        }
        .registration_form input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .registration_form .submit_btn {
            margin-top: 20px;
            background: #1e8a08;
            color: white;
            cursor: pointer;
            font-weight: bold;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            transition: 0.3s;
        }
        .registration_form .submit_btn:hover {
            background: #146805;
        }
        .wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }
    </style>
</head>
<body>
<?php
session_start();
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_name = $_POST['user_name'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $con_pass = $_POST['cpassword'];

    if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) {
        if ($password == $con_pass) {
            // Store user data
            $user_id = rand(1000, 9999);
            $query = "INSERT INTO users (user_id, First_Name, Last_Name, username, email, password) 
                      VALUES ('$user_id', '$fname', '$lname', '$user_name', '$email', '$password')";

            if (mysqli_query($conn, $query)) {
                $_SESSION['user_id'] = $user_id; // Log in user immediately
                echo "<script>
                        alert('Registration successful! Redirecting to booking page...');
                        window.location.href='seat_selection.php';
                      </script>";
                exit();
            }
        } else {
            echo "<script>alert('Passwords do not match!');</script>";
        }
    } else {
        echo "<script>alert('Invalid registration details!');</script>";
    }
}
?>

    <div class="wrapper">
        <div class="registration_form">
        <img src="image/logo.png" alt="" width="315px" height="100px">
            <div class="title">Sign Up</div>
            <form method="POST">
                <label for="fname">First Name</label>
                <input type="text" id="fname" name="fname" placeholder="First Name" required>
                <label for="lname">Last Name</label>
                <input type="text" id="lname" name="lname" placeholder="Last Name" required>
                <label for="email">Email Address</label>
                <input type="text" id="email" name="email" placeholder="E-mail" required>
                <label for="uname">Username</label>
                <input type="text" id="uname" name="user_name" placeholder="Username" required>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <label for="cpassword">Confirm Password</label>
                <input type="password" id="cpassword" name="cpassword" placeholder="Confirm Password" required>
                <input type="submit" value="Register Now" class="submit_btn">
                <a href="Login.php" class="forgot-password">Back</a>
            </form>
        </div>
    </div>
</body>
</html>










