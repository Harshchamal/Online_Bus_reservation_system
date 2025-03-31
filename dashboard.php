<?php
session_start();
include("connection.php");


if (!isset($_SESSION['passenger_id'])) {
    echo "<script>alert('Please log in to access your dashboard.'); window.location.href='userlogin.php';</script>";
    exit();
}

$passenger_id = $_SESSION['passenger_id'];


$user_query = "SELECT name, id_number, mobile, email, address, profile_picture FROM passengers WHERE id = ?";
$stmt = $conn->prepare($user_query);
$stmt->bind_param("i", $passenger_id);
$stmt->execute();
$user_result = $stmt->get_result();

if ($user_result->num_rows > 0) {
    $user = $user_result->fetch_assoc();
} else {
    echo "<script>alert('User not found.'); window.location.href='userlogin.php';</script>";
    exit();
}


$profile_picture = !empty($user['profile_picture']) ? $user['profile_picture'] : "default-avatar.png";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="cssfile/dashboard.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
    font-family: 'Arial', sans-serif;
    background: linear-gradient(rgba(43, 38, 38, 0.85), rgba(9, 179, 51, 0.85)), 
                url('image/C.jpg');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}
    </style>
</head>
<body>
    <div class="container">
        <h2 class="settings-title">Account Settings</h2>

        <div class="settings-container">
            <!-- Sidebar Navigation -->
            <div class="sidebar">
               
                <a href="dashboard.php" class="active">My Profile</a>
                <a href="mybookings.php">My Booking</a>
                <a href="LiveChat.php">Chat Live</a>
            </div>

            <!-- Profile Form Section -->
            <div class="content">
                <!-- Profile Picture Upload -->
                <div class="profile-picture">
                    <img src="<?= htmlspecialchars($profile_picture); ?>" alt="Profile Picture">
                    <div>
                        <form method="POST" enctype="multipart/form-data" id="uploadProfilePic">
                            <input type="file" name="profile_picture">
                            <button type="submit" class="btn btn-primary">Upload new photo</button>
                            
                        </form>
                        
                    </div>
                </div>

                <!-- User Profile Form -->
                <form id="updateProfileForm">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($user['name']); ?>" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Mobile Number</label>
                        <input type="text" name="mobile" value="<?= htmlspecialchars($user['mobile']); ?>" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Address (Optional)</label>
                        <input type="text" name="address" value="<?= htmlspecialchars($user['address'] ?? ''); ?>" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Save changes</button>
                    <button type="reset" class="btn btn-secondary mt-3">Cancel</button>
                </form>
            </div>
        </div>
    </div>

    <script>
      $(document).ready(function () {
    // Profile Picture Upload Form Submission
    $("#uploadProfilePic").submit(function (event) {
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "update_profile_picture.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (response) {
                alert(response.message);
                if (response.status === "success") {
                    location.reload();
                }
            },
            error: function () {
                alert("Error uploading profile picture.");
            }
        });
    });
});

    </script>
</body>
</html>









