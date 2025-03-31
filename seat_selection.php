<?php
session_start();
include("connection.php");

$booked_seats = [];
$seat_price = 1640;

// Handle Journey Data from Busshedule.php
if (isset($_POST['via_city'], $_POST['destination'])) {
    $_SESSION['via_city'] = $_POST['via_city'];
    $_SESSION['destination'] = $_POST['destination'];
}

$via_city = $_SESSION['via_city'] ?? 'Not Selected';
$destination = $_SESSION['destination'] ?? 'Not Selected';
$bus_route = "$via_city → $destination";

// Auto-clean expired temporary bookings (older than 2 minutes)
$conn->query("DELETE FROM bookings WHERE status='temp' AND created_at < (NOW() - INTERVAL 2 MINUTE)");

// Fetch permanently booked and temporarily locked seats
$result = $conn->query("SELECT seats, gender, status FROM bookings WHERE status IN ('booked', 'temp')");
while ($row = $result->fetch_assoc()) {
    foreach (explode(",", $row['seats']) as $seat) {
        $booked_seats[$seat] = ($row['status'] === 'temp') ? 'temp' : $row['gender'];
    }
}

// AJAX request handler for seat selection
if ($_SERVER["REQUEST_METHOD"] == "POST" && strpos($_SERVER["CONTENT_TYPE"], "application/json") !== false) {
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents("php://input"), true);

    if (empty($data['seats']) || empty($data['gender']) || empty($data['date']) || empty($data['departure']) || empty($data['arrival'])) {
        echo json_encode(["message" => "All fields are required."]);
        exit;
    }

    $seats = implode(",", array_map('intval', $data['seats']));
    $gender = $conn->real_escape_string($data['gender']);
    $date = $conn->real_escape_string($data['date']);
    $departure = $conn->real_escape_string($data['departure']);
    $arrival = $conn->real_escape_string($data['arrival']);
    $total_price = count($data['seats']) * $seat_price;

    // Insert temporary booking
    $conn->query("INSERT INTO bookings (seats, gender, journey_date, departure, arrival, total_price, bus_route, status, created_at) VALUES ('$seats', '$gender', '$date', '$departure', '$arrival', '$total_price', '$bus_route', 'temp', NOW())");

    // Store booking details in session
    $_SESSION['seats'] = $data['seats'];
    $_SESSION['gender'] = $gender;
    $_SESSION['date'] = $date;
    $_SESSION['departure'] = $departure;
    $_SESSION['arrival'] = $arrival;
    $_SESSION['total_price'] = $total_price;
    $_SESSION['bus_route'] = $bus_route;

    echo json_encode(["message" => "Seats temporarily locked. Proceed to details page.", "redirect" => "details.php"]);
    exit;
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Ticket Booking</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="cssfile/seat_selection.css">
    
    <style>
        body {
    font-family: 'Arial', sans-serif;
    background: linear-gradient(rgba(43, 38, 38, 0.85), rgba(9, 179, 51, 0.85)), 
                url('image/C.jpg');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
 
}

        
/* Selected seats (Red before payment) */
.selected-seat {
    background-color: red !important;
    color: white;
}

/* Booked Seats (After Payment) */
.male-booked {
    background-color: blue !important;
    color: white;
}

.female-booked {
    background-color: pink !important;
    color: black;
}

.other-booked {
    background-color: gray !important;
    color: white;
}

/* Temporary locked seats (Yellow) */
.temp-locked {
    background-color: rgb(238, 255, 0) !important;
    color: black;
}

/* Available seats (Green) */
.available {
    background-color: green !important;
    color: white;
}

/* Seat Layout */
.seat {
    width: 40px;
    height: 40px;
    margin: 5px;
    text-align: center;
    line-height: 40px;
    border-radius: 5px;
    font-weight: bold;
    cursor: pointer;
    display: inline-block;
    border: 1px solid black;
}


    </style>
</head>
<body>
<nav>
    <div class="logo">
        <img src="image/logo.png" alt="Logo" />
    </div>
    <div class="links">
        <div class="link"><a href="home.php">Home</a></div>
        <div class="link"><a href="Bustime.php">Bus Timetables</a></div>
        <div class="link"><a href="service.php">Service</a></div>
        <div class="link"><a href="gallery.php">Gallery</a></div>
        <div class="link"><a href="contact.php">Contact</a></div>
    </div>
    <div class="buttons">
            <button data-aos="fade-up" data-aos-duration="1200" data-aos-delay="7000"><a href="userlogin.php">Login and Cancelation Policy</a></button>
        </div>
</nav>


    <!-- Journey Details Header -->
<header class="journey-header">
    <?php 
    if ($via_city !== 'Not Selected' && $destination !== 'Not Selected') {
        echo "<h2>Journey: $via_city → $destination</h2>";
    } else {
        echo "<h2>No Journey Details Available</h2>";
    }
    ?>
</header>


    <div class="container-wrapper">
        <div class="container">
            <h2 class="text-center">Bus Ticket Booking</h2>
            <form id="booking-form" class="mb-3">
                <div class="form-group">
                    <label for="gender">Gender:</label>
                    <select id="gender" class="form-select">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option> 
                    </select>
                </div>
                <div class="form-group">
                    <label for="date">Date:</label>
                    <input type="date" id="date" class="form-control">
                </div>
                <div class="form-group">
                    <label for="departure">Departure:</label>
                    <input type="text" id="departure" class="form-control">
                </div>
                <div class="form-group">
                    <label for="arrival">Arrival:</label>
                    <input type="text" id="arrival" class="form-control">
                </div>
                <div class="form-group">
                    <label>Selected Seats:</label>
                    <span id="selected-seats">None</span>
                </div>
                <div class="form-group">
                    <label>Total Price:</label>
                    <span id="total-price">Rs 0</span>
                </div>
            </form>
            <div class="gender-indicator">
                <span><div class="gender-box" style="background-color: blue;"></div>Gents</span>
                <span><div class="gender-box" style="background-color: pink;"></div>Ladies</span>
                <span><div class="gender-box" style="background-color: green;"></div>Available</span>
                <span><div class="gender-box" style="background-color: gray;"></div>Others</span>
                <span><div class="gender-box" style="background-color: yellow;"></div>Temporary locked</span>
            </div>
            <button class="btn btn-primary w-100" id="bookNow">Book Now</button>
        </div>
        
        <div class="seat-layout-container" id="bus-layout"></div>
    </div>



    <script>
document.addEventListener("DOMContentLoaded", function () {
    let busLayout = document.getElementById("bus-layout");
    let bookedSeats = <?php echo json_encode($booked_seats); ?>;
    let selectedSeats = new Set();
    let seatPrice = <?php echo $seat_price; ?>;

    function updateSeatInfo() {
        document.getElementById("selected-seats").innerText = selectedSeats.size ? Array.from(selectedSeats).join(", ") : "None";
        document.getElementById("total-price").innerText = `Rs ${selectedSeats.size * seatPrice}`;
    }

    function getSeatClass(seatNumber) {
        if (bookedSeats[seatNumber]) {
            if (bookedSeats[seatNumber] === "male") return "male-booked";
            if (bookedSeats[seatNumber] === "female") return "female-booked";
            if (bookedSeats[seatNumber] === "other") return "other-booked";
            if (bookedSeats[seatNumber] === "temp") return "temp-locked";
        }
        return "available";
    }

    function generateSeatLayout() {
        busLayout.innerHTML = "";

        for (let row = 0; row < 10; row++) {
            let rowDiv = document.createElement("div");
            rowDiv.classList.add("row-seat");

            for (let col = 0; col < 5; col++) {
                if (col === 2) rowDiv.appendChild(document.createElement("div")).classList.add("aisle");

                let seatNumber = (row * 5 + col + 1).toString();
                let seat = document.createElement("div");
                seat.classList.add("seat", getSeatClass(seatNumber));
                seat.innerText = seatNumber;
                seat.setAttribute("data-seat", seatNumber);

                if (!bookedSeats[seatNumber]) {
                    seat.addEventListener("click", function () {
                        if (selectedSeats.has(seatNumber)) {
                            selectedSeats.delete(seatNumber);
                            seat.classList.replace("selected-seat", "available");
                        } else {
                            selectedSeats.add(seatNumber);
                            seat.classList.replace("available", "selected-seat");
                        }
                        updateSeatInfo();
                    });
                }
                rowDiv.appendChild(seat);
            }
            busLayout.appendChild(rowDiv);
        }
    }

    document.getElementById("bookNow").addEventListener("click", function () {
    let gender = document.getElementById("gender").value;
    let date = document.getElementById("date").value;
    let departure = document.getElementById("departure").value.trim();
    let arrival = document.getElementById("arrival").value.trim();

    if (!gender || !date || !departure || !arrival || selectedSeats.size === 0) {
        alert("Please fill all fields and select at least one seat.");
        return;
    }

    fetch("seat_selection.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            seats: Array.from(selectedSeats),
            gender: gender,
            date: date,
            departure: departure,
            arrival: arrival
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error("Network response error: " + response.statusText);
        }
        return response.json();
    })
    .then(data => {
        alert(data.message);
        if (data.redirect) {
            window.location.href = data.redirect;
        }
    })
    .catch(error => {
        alert("AJAX Error: " + error.message);
        console.error("Detailed error:", error);
    });
});


    generateSeatLayout();
});
</script>



</body>
</html>