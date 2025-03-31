
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Neelawala express time table</title>

  
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cssfile/Bustime.css">
    <style>
      /*footer section*/
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

footer{
    background: #0bbb5a;
    padding-top: 50px;
}
.container{
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



<?php include("connection.php");?>

<h1 class="topic_bus"> ...Our Buses...</h1>

<?php
$sqlget = "SELECT * FROM bus";
$sqldata = mysqli_query($conn, $sqlget) or die('Error retrieving data');

echo "<table>";
echo "<tr>
        <th>ID</th>
        <th>Bus Number</th>
        <th>Conductor Number</th>
      </tr>";

while ($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)) {
    echo "<tr><td>";
    echo $row['id'];
    echo "</td><td>";
    echo $row['bus_number'];  // updated field
    echo "</td><td>";
    echo $row['conductor_number'];  // updated field
    echo "</td></tr>";
}
echo "</table>";
?>




<h1 class="topic_bus"> ...Our Route Services...</h1>

<?php
  
    $sqlget="SELECT * FROM route";
    $sqldata=mysqli_query($conn,$sqlget) or die('error getting');

    echo "<table>";
    echo "<tr>
      <th>ID</th>
    <th>Via City</th>
    <th>Destination</th>
    <th>Bus Name</th>
    <th>Departure Date</th>
    <th>Departure Time</th>
    <th>Cost</th>
  
   
       </tr>";

       while ($row=mysqli_fetch_array($sqldata,MYSQLI_ASSOC))
       {
        echo "<tr><td>";
        echo $row['id'];
        echo "</td><td>";
        echo $row['via_city'];
        echo "</td><td>";
        echo $row['destination'];
        echo "</td><td>";
        echo $row['bus_name'];
        echo "</td><td>";
         echo $row['departure_date'];
        echo "</td><td>";
         echo $row['departure_time'];
        echo "</td><td>";
         echo $row['cost'];
        echo "</td>";
       
          
        ?>

        </tr>

<?php
       }

       echo "</table>";


?>


          

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



  </body>
</html>
