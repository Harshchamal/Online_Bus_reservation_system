<?php
session_start();
include("connection.php");

if (!isset($_SESSION['passenger_id'])) {
    echo "<script>alert('Please log in to access Live Chat.'); window.location.href='userlogin.php';</script>";
    exit();
}

$passenger_id = $_SESSION['passenger_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Chat Support</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="cssfile/livechat.css"> 
</head>
<body>
    <div class="container">
        <h2 class="settings-title">Live Chat Support</h2>

        <div class="settings-container">
            <!-- Sidebar Navigation -->
            <div class="sidebar">
                <a href="dashboard.php">My Profile</a>
                <a href="mybookings.php">My Bookings</a>
                <a href="livechat.php" class="active">Live Chat</a>
            </div>

            <!-- Live Chat Section -->
            <div class="content">
                <h3>Chat with Support</h3>

                <div class="chat-container">
                    <div class="chat-box" id="chatBox">
                        <p class="chat-message support">👋 Welcome to Neelawala Express Live Chat. Type **"Hi"** to begin.</p>
                    </div>

                    <form id="chatForm">
                        <input type="text" id="userMessage" placeholder="Type your message..." required>
                        <button type="submit" class="btn-primary">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("chatForm").addEventListener("submit", function(event) {
            event.preventDefault();
            let userMessage = document.getElementById("userMessage").value.trim();
            let chatBox = document.getElementById("chatBox");

            // User message display
            let userMessageElement = document.createElement("p");
            userMessageElement.classList.add("chat-message", "user");
            userMessageElement.innerHTML = userMessage;
            chatBox.appendChild(userMessageElement);
            document.getElementById("userMessage").value = "";

            // Chatbot response logic
            setTimeout(() => {
                let supportMessageElement = document.createElement("p");
                supportMessageElement.classList.add("chat-message", "support");

                if (userMessage.toLowerCase() === "hi") {
                    supportMessageElement.innerHTML = "Hello! You can cancel your ticket. Can you please send your **Gmail notification & Invoice Number** for verification?";
                } else if (userMessage.match(/^INV-\d+$/)) {
                    supportMessageElement.innerHTML = "✅ Thank you! We have received your Invoice No: **" + userMessage + "**. We will now verify your refund request.";
                } else {
                    supportMessageElement.innerHTML = "I'm sorry, I didn't understand that. Please send **'Hi'** or provide your Invoice No (Example: **INV-123**).";
                }

                chatBox.appendChild(supportMessageElement);
                chatBox.scrollTop = chatBox.scrollHeight;
            }, 2000);
        });
    </script>

</body>
</html>
