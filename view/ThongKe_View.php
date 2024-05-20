<?php
// Include tệp kết nối cơ sở dữ liệu và mô hình
include_once '../model/DB.php';
include_once '../model/HoaDon.php';
include_once '../model/KhachHang.php';

$db = new DB();

// Khởi tạo đối tượng HoaDonModel
$hoaDonModel = new HoaDon($db);
$KhachHangModel = new KhachHang($db);

// Gọi phương thức để tính tổng thành tiền của các hóa đơn
$totalThanhTien = $hoaDonModel->getTotalThanhTien();
$totalHoaDon = $hoaDonModel->countHoaDon();
$totalKH = $KhachHangModel->countKhachHang();


?>


<!doctype html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
  <head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <title>Quản lý thông tin khách hàng</title>
    <link rel="stylesheet" type="text/css" href="style.css">
<style>
.card-container {
    display: flex;
    gap: 2rem; /* Khoảng cách giữa các thẻ */
}
.card {
    width: 250px;
    height: 124px;
    border-radius: 20px;
    background: #f5f5f5;
    position: relative;
    padding: 1.8rem;
    border: 2px solid #c3c6ce;
    transition: 0.5s ease-out;
    overflow: visible;
}

.card-details {
    color: black;
    height: 100%;
    gap: .5em;
    display: grid;
    place-content: center;
}

.card-button {
    transform: translate(-50%, 125%);
    width: 60%;
    border-radius: 1rem;
    border: none;
    background-color: #008bf8;
    color: #fff;
    font-size: 1rem;
    padding: .5rem 1rem;
    position: absolute;
    left: 50%;
    bottom: 0;
    opacity: 0;
    transition: 0.3s ease-out;
}

.text-body {
    font: optional;
    font-size:1rem;
    text-align: center;
    color: rgb(134, 134, 134);
}

/* Text */
.text-title {
    font-size: 1.5em;
    font-weight: bold;
}

/* Hover */
.card:hover {
    border-color: #008bf8;
    box-shadow: 0 4px 18px 0 rgba(0, 0, 0, 0.25);
}

.card:hover .card-button {
    transform: translate(-50%, 50%);
    opacity: 1;
}

</style>

  </head>
  <body>
    
      <div class="row">
        <div class="col-md-8"></div>
        <div class="col-6 col-md-4"></div>
      </div>

      <div class="row">
        <div id="menu"></div>
      </div>
      <div class="container">
      <div class="row shadow-lg p- mb-5 bg-body-tertiary rou3nded">
        <div class="col-2">
          <div id="sidebar"></div>
        </div>
      
        <div class="col-10" style="padding: 20px 20px 20px 10px;">


         
<div class="card-container">
   <div class="row ">
   <div class="card-container">
        <div style="margin-left:100px" class="card">
            <div class="card-details">
                <img src="../image/money.gif" style="height: 64px; width: 64px;margin-left: 32px">
                <p class="text-title">Doanh thu</p>
                <p class="text-body"><b><?php  echo $totalThanhTien; ?> đ</b></p>
            </div>
            <button class="card-button">More info</button>
        </div> 
    
   
        <div class="card">
            <div class="card-details">
                 <img src="../image/box-ezgif.com-resize.gif" style="height: 64px; width: 64px; margin-left: 27px">
                <p class="text-title">Đơn hàng</p>
                <p class="text-body"><b><?php  echo $totalHoaDon; ?></b></p>
            </div>
            <button class="card-button" >More info</button>
        </div>
   
        <div class="card">
            <div class="card-details">
            <img src="../image/appraisal.gif" style="height: 64px; width: 64px;margin-left: 37px">
                <p class="text-title">Khách hàng</p>
                <p class="text-body"><b><?php echo $totalKH; ?></b></p>
            </div>
            <button class="card-button">More info</button>
        </div>
    
</div></div>
</div>
          
        </div>
      </div>
      </div>

      <div class="row">
        <div id="footer">
        </div>
      </div>
    </div>

    <script>
      async function loadContent() {
        try {
          const response = await fetch('Menu_QL.php');
          const content = await response.text();
          document.getElementById('menu').innerHTML = content;
        } catch (error) {
          console.error('Error loading content:', error);
        }
      }
      loadContent();

      async function loadSidebar() {
        try {
          const response = await fetch('SideBar_QL.php');
          const content = await response.text();
          document.getElementById('sidebar').innerHTML = content;
        } catch (error) {
          console.error('Error loading sidebar:', error);
        }
      }
      loadSidebar();

      async function loadFooter() {
        try {
          const response = await fetch('Footer.php');
          const content = await response.text();
          document.getElementById('footer').innerHTML = content;
        } catch (error) {
          console.error('Error loading footer:', error);
        }
      }
      loadFooter();
    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
  </body>
</html>
