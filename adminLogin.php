<?php 

    session_start();
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Neelawala Express Admin Login</title>
    <link rel="stylesheet" href="cssfile/login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style >
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
            background: rgba(255, 255, 255, 0.8);
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
        .login-box input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
        }
        .login-box input[type="submit"] {
            background: #1e8a08;
            color: white;
            cursor: pointer;
            font-weight: bold;
        }
        .login-box input[type="submit"]:hover {
            background: #1e8a08;
        }
        .sign_up, .forgot-password {
            display: inline-block;
            margin-top: 10px;
            color: #1e8a08;
            text-decoration: none;
        }
        .sign_up:hover, .forgot-password:hover {
            text-decoration: underline;
        }



    </style>

  </head>
  <body>
              
<?php include("connection.php"); ?>

 <div class="login-box">
 <img src="image/logo.png" alt="" width="315px" height="100px">

            <h1>Admin Login</h1>
            <form method="POST">
                    <p>Username</p>
                    <input type="text" name="Admin_username" placeholder="Enter Username">
                    <p>Password</p>
                    <input type="password" name="Admin_password" placeholder="Enter Password">
                    <input type="submit" name="login" value="Login">
                   <a href="home.php" class="sign_up">Back</a>&nbsp&nbsp&nbsp
                       
            </form>

 </div>
<?php 

    if(isset($_POST['login'])){
        $query="SELECT * FROM `admin` WHERE username='$_POST[Admin_username]'  AND  password='$_POST[Admin_password]'";
        $result=mysqli_query($conn,$query);
        if(mysqli_num_rows($result)==1){

        // session_start();//
         $_SESSION['username']=$_POST['Admin_username'];
         header("location:adminDash.php");
        }
        else{
          echo '<script type="text/javascript">alert("incorrect_pass!!!")</script>';
        }
        
    }
?>

  </body>
</html>
