<?php
require_once '../model/DB.php';
require_once '../model/TaiKhoanNV.php';
require_once '../controller/TaiKhoanNV_con.php';

$db = new DB();
$taiKhoanNV = new TaiKhoanNVController($db);


// Kiểm tra đăng nhập khi form được gửi đi
if(isset($_POST['submit'])) {
  // Lấy thông tin từ form
  $UserName = $_POST['UserName'];
  $MatKhau = $_POST['MatKhau'];

  // Kiểm tra thông tin đăng nhập
  $result = $taiKhoanNV->Checklogin($UserName, $MatKhau);

  if($result) {
    // Đăng nhập thành công, lưu thông tin vào session và chuyển hướng đến trang ThongKe_View.php
    session_start();
    $_SESSION['UserName'] = $UserName; // Lưu thông tin người dùng đăng nhập vào session
    header("Location: ../view/ThongKe_View.php"); // Chuyển hướng đến trang thống kê
    exit();
} else {
    // Thông tin đăng nhập không chính xác, hiển thị thông báo lỗi
    $error = "Invalid username or password!";
}

}



?>


<!doctype html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
  <head>
    <meta content="text/html ; charset=utf-8" http-equiv="Content-Type">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <title>Đăng nhập</title>
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
   <div class="container">
    <div class="row">
<div class="col-6">
  <form class="form" method="post" >
       <p class="form-title">Sign in to your account</p>
       <?php if(isset($error)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

        <div class="input-container">
          <input type="user" name="UserName" placeholder="Enter usename">
          <span>
          </span>
      </div>
      <div class="input-container">
          <input type="password" name="MatKhau" placeholder="Enter password">
        </div>
         <button type="submit" name="submit" class="submit">
        Sign in
      </button>

      <p class="signup-link">
        No account?
        <a href="">Sign up</a>
      </p>
   </form></div>

<div class="col-5"><img src="../image/home.gif" alt="Description of your GIF" style="width: 500px; height: 500px; margin-top:50px">
</div>
    </div>
   




        
  </div>


</body>
</html>
