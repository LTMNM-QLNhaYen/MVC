<?php
   session_start();

   include_once '../model/DB.php';
   include_once '../controller/KhachHang_con.php';
  
$db = new DB();

$loginHandler = new KhachHangController($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $UserName = $_POST['username'];
    $MatKhau = $_POST['password'];
    
    $user = $loginHandler->Checklogin($UserName, $MatKhau);
    if ($user) {
        // Start a new session and store user information
        $_SESSION['user_id'] = $user['MaKH'];
        $_SESSION['username'] = $user['UserName'];
        $_SESSION['tenkh'] = $user['TenKH'];
        
        // Redirect to the homepage
        header("Location: 1_TrangChu.php");
        exit(); // Make sure to exit after the redirection
    } else {
        echo "Login failed. Invalid username, password, or account is locked.";
    }}

    ?>
    
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce Website</title>
    <link rel="stylesheet" href="styles.css">
    <!-- Slick Slider CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
<style>

.login {
  width: 340px;
  height: 400px;
  background: #fff;
  padding: 47px;
  padding-bottom: 57px;
  color: black;
  border-radius: 17px;
  padding-bottom: 50px;
  font-size: 1.3em;
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
}

.login input[type="text"],
.login input[type="password"] {
  opacity: 1;
  display: block;
  border: none;
  outline: none;
  width: 100%;
  padding: 13px 18px;
  margin: 20px 0 0 0;
  font-size: 0.8em;
  border-radius: 100px;
  background: #C6E2FF;
  color: black;
}

.login input:focus {
  animation: bounce 1s;
  -webkit-appearance: none;
}

.login input[type=submit],
.login input[type=button],
.h1 {
  border: 0;
  outline: 0;
  width: 100%;
  padding: 13px;
  margin: 40px 0 0 0;
  border-radius: 500px;
  font-weight: 600;
  animation: bounce2 1.6s;
}

.h1 {
  padding: 0;
  position: relative;
  top: -35px;
  display: block;
  margin-bottom: -0px;
  font-size: 1.3em;
}

.btn {
  background: linear-gradient(144deg, #af40ff, #5b42f3 50%, #00ddeb);
  color: #fff;
  padding: 16px !important;
}

.btn:hover {
  background: linear-gradient(144deg, #1e1e1e , 20%,#1e1e1e 50%,#1e1e1e );
  color: rgb(255, 255, 255);
  padding: 16px !important;
  cursor: pointer;
  transition: all 0.4s ease;
}

.login input[type=text] {
  animation: bounce 1s;
  -webkit-appearance: none;
}

.login input[type=password] {
  animation: bounce1 1.3s;
}

.ui {
  font-weight: bolder;
  background: -webkit-linear-gradient(#B563FF, #535EFC, #0EC8EE);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  border-bottom: 4px solid transparent;
  border-image: linear-gradient(0.25turn, #535EFC, #0EC8EE, #0EC8EE);
  border-image-slice: 1;
  display: inline;
}

@media only screen and (max-width: 600px) {
  .login {
    width: 70%;
    padding: 3em;
  }
}

@keyframes bounce {
  0% {
    transform: translateY(-250px);
    opacity: 0;
  }
}

@keyframes bounce1 {
  0% {
    opacity: 0;
  }

  40% {
    transform: translateY(-100px);
    opacity: 0;
  }
}

@keyframes bounce2 {
  0% {
    opacity: 0;
  }

  70% {
    transform: translateY(-20px);
    opacity: 0;
  }
}
</style>



</head>
<body>
 <div class="row">
<div  class="col-4"></div>
<div class="login wrap">
  <div class="h1">Login</div>
  <form method="POST" action="">
  <input placeholder="Username" id="username" name="username" type="text">
  <input placeholder="Password" id="password" name="password" type="password">
  <input value="Login" class="btn" type="submit"></form>
</div>
</div>  




</body>
</html>

