<?php 
include("connection.php"); 

// Fetch unique departure stations from the database
$departure_query = "SELECT DISTINCT via_city FROM route ORDER BY via_city ASC";
$departure_result = $conn->query($departure_query);

// Fetch unique arrival stations from the database
$arrival_query = "SELECT DISTINCT destination FROM route ORDER BY destination ASC";
$arrival_result = $conn->query($arrival_query);

// Fetch unique departure dates from the database
$date_query = "SELECT DISTINCT departure_date FROM route ORDER BY departure_date ASC";
$date_result = $conn->query($date_query);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Neelawala Express</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/confirmDate/confirmDate.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/confirmDate/confirmDate.js"></script>

    <link rel="stylesheet" href="cssfile/home.css">

    <title>Ticket Booking</title>
    <style>

.booking-section {
    padding: 250px 0;
    background: linear-gradient(rgba(16, 90, 28, 0.85), rgba(20, 117, 44, 0.85)), url('image/C.jpg');
    background-size: cover;
    background-position: center;
    color: #fff;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
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

<section class="booking-section">
    <div class="booking-container">
        <h2>The simplest way to book your bus tickets in Sri Lanka</h2>
        <form id="busForm" action="Busshedule.php" method="POST" class="booking-form">
            
            <!-- Dynamic Departure Selection -->
            <select id="pickup" name="pickup_point" required>
                <option value="" disabled selected>Enter your departure station</option>
                <?php while ($row = $departure_result->fetch_assoc()): ?>
                    <option value="<?= htmlspecialchars($row['via_city']); ?>"><?= htmlspecialchars($row['via_city']); ?></option>
                <?php endwhile; ?>
            </select>

            <!-- Dynamic Arrival Selection -->
            <select id="drop" name="drop_point" required>
                <option value="" disabled selected>Enter your arrival station</option>
                <?php while ($row = $arrival_result->fetch_assoc()): ?>
                    <option value="<?= htmlspecialchars($row['destination']); ?>"><?= htmlspecialchars($row['destination']); ?></option>
                <?php endwhile; ?>
            </select>

            <!-- Dynamic Departure Date Selection -->
            <input type="text" id="date" name="date" placeholder="Select your journey date" class="form-control" required>

            <button type="submit">Find Buses</button>
        </form>
    </div>
</section>


<!-- Vision & Mission Section -->
<section class="vision-mission">
    <div class="container">
        <div class="vision-mission-content">
            
            
            <div class="text-content">
                <h5>Welcome to Neelawala EXPRESS</h5>
                <h2>Our Vision and Mission</h2>

                <div class="vision-block">
                    <h3 class="vision-heading">Vision</h3>
                    <p class="vision-text">
                    To be the leading provider of safe, reliable, and efficient long-distance bus travel, 
                    offering seamless digital booking solutions for an enhanced passenger experience in Sri Lanka..
                    </p>
                </div>

                <div class="mission-block">
                    <h3 class="mission-heading">Mission</h3>
                    <p class="mission-text">
                    Enhancing Convenience Provide a user-friendly online booking system that allows passengers to reserve seats anytime, anywhere.
                    Ensuring Safety & Comfort  Maintain high safety standards and offer a comfortable travel experience through well-maintained buses and excellent service.
                    Innovation & Technology  Continuously improve our digital services with real-time seat availability, secure payment options, and automated booking confirmations.
                    Customer Satisfaction  Deliver exceptional customer service by offering responsive support and flexible booking policies.
                    </p>
                </div>
            </div>

            <!-- Right Side: Vision & Mission Image -->
            <div class="image-content">
                <img src="image/new.jpg" alt="Vision and Mission Image" width="300px" height="500px">
            </div>
        </div>
    </div>
</section>


<!-- User Journey View Section -->
<section class="destinations-section">
    <div class="destinations-header">
        <div class="header-left">
           
            <h2>Our Destinations</h2>
        </div>
      
    </div>

    <div class="destinations-container">
        <!-- Destination Card 1 -->
        <div class="destination-card">
            <img src="image/mathara.png" alt="mathara">
            <div class="card-overlay">
                <h3>MATHARA</h3>
                <p>Mathara - Kaduruwela</p>
            </div>
        </div>

        <!-- Destination Card 2 -->
        <div class="destination-card">
            <img src="image/walikanda1.jpeg" alt="walikanda">
            <div class="card-overlay">
                <h3>WALIKANDA</h3>
                <p>walikanda - Colombo</p>
            </div>
        </div>

        <!-- Destination Card 3 -->
        <div class="destination-card">
            <img src="image/kaduruwela.jpeg" alt="kaduruwela">
            <div class="card-overlay">
                <h3>KADURUWELA</h3>
                <p>Colombo - JKADURUWELA</p>
            </div>
        </div>
        

        <!-- Destination Card 4 -->
        <div class="destination-card">
            <img src="image/colombo.jpeg" alt="colombo">
            <div class="card-overlay">
                <h3>COLOMBO</h3>
                <p>Panadura - Kandy</p>
            </div>
        </div>
    </div>
</section>


<!-- about section -->


<section class="about_section">
    <div class="about_container">
        
        <!-- Left Side: Organized Images Grid -->
        <div class="about_images">
            <div class="image-grid">
                <img src="image/6.jpg" alt="Bus Image 1">
                <img src="image/2.jpg" alt="Bus Image 2">
                <img src="image/3.jpg" alt="Bus Image 3">
                <img src="image/4.jpg" alt="Bus Image 4">
                
                <!-- Service Badge in the Center -->
                <div class="service_badge">
            

                    
                    <h4>Excellent Service</h4>
                    <p>Neelawala EXPRESS Elevating Travel with Comfort, Safety, and Punctuality.</p>
                </div>
            </div>
        </div>

        <!-- Right Side: About Content -->
        <div class="about_content">
            <h2>Company Profile</h2>
            <p>Neelawala Express Private Limited is one of the largest and most trusted transport providers in Sri Lanka...</p>

            <ul>
                <li>Secure payment options for your peace of mind.</li>
                <li>Highly trained drivers with excellent safety records.</li>
                <li>Timely departures and arrivals to ensure you reach your destination on time.</li>
                <li>We offer a comprehensive network of scheduled routes.</li>
                <li>Your safety is our priority. We adhere to strict safety protocols.</li>
            </ul>
        </div>
    </div>
</section>


<!-- end about section -->


<footer>
  <div class="container">
      <div class="footer-content">
          <h3>Contact Us</h3>
          <p>Email:Info@example.com</p>
          <p>Phone:+121 56556 565556</p>
          <p>Address:Your Address 123 street</p>
      </div>
      <div class="footer-content">
          <h3>Quick Links</h3>
           <ul class="list">
              <li><a href="">Home</a></li>
              <li><a href="">Bus Timetables</a></li>
              <li><a href="">Services</a></li>
              <li><a href="">Gallery</a></li>
              <li><a href="">Contact</a></li>
           </ul>
      </div>
      <div class="footer-content">
          <h3>Follow Us</h3>
          <ul class="social-icons">
           <li><a href=""><i class="fab fa-facebook"></i></a></li>
           <li><a href=""><i class="fab fa-twitter"></i></a></li>
           <li><a href=""><i class="fab fa-instagram"></i></a></li>
           <li><a href=""><i class="fab fa-linkedin"></i></a></li>
          </ul>
          </div>
  </div>
</footer>


<script>
    flatpickr("#date", {
        altInput: true,
        altFormat: "F j, Y",         
        dateFormat: "Y-m-d",         
        defaultDate: "today",       
        minDate: "today",           
        allowInput: true,
        plugins: [
            new confirmDatePlugin({
                showAlways: false,
                confirmText: "OK",
                theme: "light"
            })
        ]
    });
</script>


</body>
</html>