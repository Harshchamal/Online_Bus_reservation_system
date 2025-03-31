<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Suraksha Insurance Solutions</title>
    <link rel="stylesheet" href="cssfile/contact.css">
    <script src="https://kit.fontawesome.com/c32adfdcda.js" crossorigin="anonymous"></script>
    <link href="http://fonts.googleapis.com/css?family=Cookie" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <style>
        /* Style the button */
.buttons button {
    padding: 15px 20px;
    border: none;
    border-radius: 5px;
    background: rgb(12, 112, 10);
    cursor: pointer;
    transition: background 0.3s ease;
    width: 180px;  /* Set a fixed width for proper text wrapping */
    white-space: normal; /* Allows text to wrap */
    line-height: 1.2; /* Adjust line spacing */
    text-align: center; /* Ensure text is centered */
    font-size: 14px; /* Adjust font size for better fit */
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Ensure white text inside the button */
.buttons button a {
    color: white !important; /* Force white text */
    text-decoration: none; /* Remove underline */
    font-weight: bold;
}

/* Change button color on hover */
.buttons button:hover {
    background: #08963e;
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
        <div class="link"><a href="#">Gallery</a></div>
        <div class="link"><a href="contact.php">Contact</a></div>
    </div>
    <div class="buttons">
            <button data-aos="fade-up" data-aos-duration="1200" data-aos-delay="7000"><a href="userlogin.php">Login and Cancelation Policy</a></button>
        </div>
</nav>

    <!-- Contact Form Section -->
    <section class="contact-form">
        <div class="container">
            <h2>Contact Us</h2>
            <form action="#" method="post">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="subject">Subject:</label>
                <input type="text" id="subject" name="subject" required>

                <label for="message">Message:</label>
                <textarea id="message" name="message" required></textarea>

                <button type="submit">Send Message</button>
            </form>
        </div>
    </section>



    <footer>
  <div class="containerf">
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






  </body>
</html>