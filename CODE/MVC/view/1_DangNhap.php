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
        echo "Login failed. Invalid username, password, or account is incorrect.";
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


.form {
  background-color: #fff;
  display: block;
  padding: 1rem;
  max-width: 350px;
  border-radius: 0.5rem;
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.form-title {
  font-size: 1.25rem;
  line-height: 1.75rem;
  font-weight: 600;
  text-align: center;
  color: #000;
}

.input-container {
  position: relative;
}

.input-container input, .form button {
  outline: none;
  border: 1px solid #e5e7eb;
  margin: 8px 0;
}

.input-container input {
  background-color: #fff;
  padding: 1rem;
  padding-right: 3rem;
  font-size: 0.875rem;
  line-height: 1.25rem;
  width: 300px;
  border-radius: 0.5rem;
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
}

.submit {
  display: block;
  padding-top: 0.75rem;
  padding-bottom: 0.75rem;
  padding-left: 1.25rem;
  padding-right: 1.25rem;
  background-color: #4F46E5;
  color: #ffffff;
  font-size: 0.875rem;
  line-height: 1.25rem;
  font-weight: 500;
  width: 100%;
  border-radius: 0.5rem;
  text-transform: uppercase;
}

.signup-link {
  color: #6B7280;
  font-size: 0.875rem;
  line-height: 1.25rem;
  text-align: center;
}

.signup-link a {
  text-decoration: underline;
}
</style>



</head>
<body>
 <div class="row">
<div  class="col-2"></div>
<form class="form" method="post" style="margin-top:150px">
       <p class="form-title">Sign in to your account</p>
      
        <div class="input-container">
          <input type="user" name="username" placeholder="Enter usename">
          <span>
          </span>
      </div>
      <div class="input-container">
          <input type="password" name="password" placeholder="Enter password">
        </div>
        <div class="Forgot-password">
          <a href="Forgot_password.php">Forgot password</a>

        </div>
         <button type="submit" name="btn" class="submit">
         Sign in
      </button>

      <p class="signup-link">
        No account?
        <a href="../view/1_DangKyTaiKhoan.php">Sign up</a>
      </p>
   </form>
   <div  class="col-2"></div>
<div class="col-5">
  <br><br><br>
            <img src="../image/welcome.gif" style="width: 400px; height:400px;">
        </div>
</div>  







</body>
</html>

