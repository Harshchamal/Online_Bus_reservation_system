<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Neelawala Express</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://kit.fontawesome.com/1165876da6.js" crossorigin="anonymous"></script>
    <title>Our service</title>
    <style>

/* Navigation Bar */
body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    color: #333;
    line-height: 1.6;
}
a {
    text-decoration: none;
    color: inherit;
}

h2, h3 {
    margin: 0;
    font-weight: 600;
}

p {
    margin: 0;
    color: #666;
}

.container {
    width: 90%;
    max-width: 1200px;
    margin: 0 auto;
}


nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 0;
    background: #ffffff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    position: sticky;
    top: 0;
    z-index: 1000;
}

.logo img {
    height: auto;
    width: 200px;
}

.links {
    display: flex;
    gap: 20px;
}

.link a {
    font-weight: 500;
    color: #333;
    transition: color 0.3s ease;
}

.link a:hover {
    color: #0bbb5a;
}

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

/* General Styles */
.containerS {
    padding: 50px 20px;
    text-align: center;
    background-color: #f9f9f9;
}

.containerS h2 {
    font-size: 2.5rem;
    margin-bottom: 70px;
    color: #333;
}

.services {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
}

.card {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 300px;
    padding: 20px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-10px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.content {
    text-align: center;
}

.icon {
    font-size: 2.5rem;
    color:#1e8a08;
    margin-bottom: 15px;
}

.title {
    font-size: 1.5rem;
    font-weight: bold;
    color: #333;
    margin-bottom: 10px;
}

p {
    font-size: 1rem;
    color: #666;
    line-height: 1.5;
}

/*footer section*/

footer{
    background: #0bbb5a;
    padding-top: 50px;
}
.containerf{
    width: 1140px;
    margin: auto;
    display: flex;
    justify-content: center;
}
.footer-content{
    width: 33.3%;
}
h3{
    font-size: 28px;
    margin-bottom: 15px;
    text-align: center;
}
.footer-content p{
    width:190px;
    margin: auto;
    padding: 7px;
}
.footer-content ul{
    text-align: center;
}
.list{
    padding: 0;
}
.list li{
    width: auto;
    text-align: center;
    list-style-type:none;
    padding: 7px;
    position: relative;
}
.list li::before{
    content: '';
    position: absolute;
    transform: translate(-50%,-50%);
    left: 50%;
    top: 100%;
    width: 0;
    height: 2px;
    background: #000000;
    transition-duration: .5s;
}
.list li:hover::before{
    width: 70px;
}
.social-icons{
    text-align: center;
    padding: 0;
}
.social-icons li{
    display: inline-block;
    text-align: center;
    padding: 5px;
}
.social-icons i{
    color: rgb(0, 0, 0);
    font-size: 25px;
}
a{
    text-decoration: none;
}
a:hover{
    color: #1e8a08;
}
.social-icons i:hover{
    color: #000000;
}
.bottom-bar{
    background: #0bbb5a;
    text-align: center;
    padding: 10px 0;
    margin-top: 50px;
}
.bottom-bar p{
    color: #000000;
    margin: 0;
    font-size: 16px;
    padding: 7px;
}


/* Responsive Design */
@media (max-width: 768px) {
    .card {
        width: 100%;
        max-width: 400px;
    }
}

@media (max-width: 480px) {
    .containerS h2 {
        font-size: 2rem;
    }

    .icon {
        font-size: 2rem;
    }

    .title {
        font-size: 1.25rem;
    }

    p {
        font-size: 0.9rem;
    }
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
    
 

    <div class="containerS">
        <h2>Our Services</h2>
        <section class="services">
            <div class="card">
                <div class="content">
                    <div class="icon"><i class="fa fa-shopping-bag"></i></div>
                    <div class="title">Luggage Service</div>
                    <p>We offer luggage services for our passengers, providing a secure and convenient option for transporting their belongings.</p>
                </div>
            </div>
            <div class="card">
                <div class="content">
                    <div class="icon"><i class="fa fa-ticket"></i></div>
                    <div class="title">Online Booking</div>
                    <p>Bus companies usually have user-friendly websites or mobile apps that allow passengers to book tickets or charter services online.</p>
                </div>
            </div>
            <div class="card">
                <div class="content">
                    <div class="icon"><i class="fa fa-volume-control-phone"></i></div>
                    <div class="title">Customer Support </div>
                    <p>Bus companies typically have customer support teams that can assist passengers with inquiries, ticket changes, and other concerns..</p>
                </div>
            </div>
            <div class="card">
                <div class="content">
                    <div class="icon"><i class="fa fa-bus"></i></div>
                    <div class="title">Public Transport</div>
                    <p>Our public transport services are meticulously designed to meet the diverse needs of daily commuters, offering a comprehensive, efficient, and user-friendly network of bus routes. .</p>
                </div>
            </div>
            <div class="card">
                <div class="content">
                    <div class="icon"><i class="fa fa-map-o"></i></div>
                    <div class="title">Special Hires</div>
                    <p>Our bus special hire services offer a variety of options to suit different needs and preferences, including semi luxury, luxury, and super luxury types. .</p>
                </div>
            </div>
            
            
        </section>
    </div>


<!-- end about section -->

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
  <div class="bottom-bar">
      <p>&copy; 2023 your company . All rights reserved</p>
  </div>
  

</footer>





</body>
</html>