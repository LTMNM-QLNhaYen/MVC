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

include_once '../controller/TaiKhoanNV_con.php';
$taiKhoanController = new TaiKhoanNVController($db);
session_start();
$UserName = $_SESSION['UserName']; 

if (!isset($_SESSION['UserName'])) {
  // Nếu không đăng nhập, chuyển hướng đến trang đăng nhập
  header("Location: Login_Admin.php");
  exit(); // Dừng kịch bản để chuyển hướng được thực hiện
}

//Thong tin user
$accountInfo = $taiKhoanController->getAccountInfo($UserName);






$query = "
    SELECT 
        YEAR(NgayLapHD) AS Nam,
        MONTH(NgayLapHD) AS Thang,
        SUM(ThanhTien) AS DoanhThu,
        SUM(ThanhTien - (SELECT SUM(GiaNhap * ct.SoLuong) 
                         FROM ChiTietHoaDon ct 
                         JOIN SanPham sp ON ct.MaSP = sp.MaSP 
                         WHERE ct.MaHD = hd.MaHD)) AS LoiNhuan
    FROM 
        HoaDon hd
    WHERE 
        TrangThaiDonHang = 'Giao hàng thành công'
    GROUP BY 
        YEAR(NgayLapHD), MONTH(NgayLapHD)
    ORDER BY 
        YEAR(NgayLapHD), MONTH(NgayLapHD);
    ";

$pdo = $db->getConnection(); // Kết nối tới cơ sở dữ liệu


$stmt = $pdo->prepare($query);
if ($stmt->execute()) {
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (empty($data)) {
        echo "Query executed successfully but returned no data.<br>";
    } else {
        echo "Data fetched successfully.<br>";
        
    }
} else {
    $errorInfo = $stmt->errorInfo();
    echo "Query execution failed: " . $errorInfo[2] . "<br>";
}

$labels = [];
$doanhThu = [];
$loiNhuan = [];

foreach ($data as $row) {
    $labels[] = $row['Nam'] . '-' . str_pad($row['Thang'], 2, '0', STR_PAD_LEFT);
    $doanhThu[] = $row['DoanhThu'];
    $loiNhuan[] = $row['LoiNhuan'];
}

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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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


#btn-message {
  --text-color: #000;
  --bg-color-sup: #d2d2d2;
  --bg-color: #f4f4f4;
  --bg-hover-color: #ffffff;
  --online-status: #00da00;
  --font-size: 16px;
  --btn-transition: all 0.2s ease-out;
}

.button-message {
  display: flex;
  justify-content: center;
  align-items: center;
  font: 400 var(--font-size) Helvetica Neue, sans-serif;
  box-shadow: 0 0 2.17382px rgba(0,0,0,.049),0 1.75px 6.01034px rgba(0,0,0,.07),0 3.63px 14.4706px rgba(0,0,0,.091),0 22px 48px rgba(0,0,0,.14);
  background-color: var(--bg-color);
  border-radius: 68px;
  cursor: pointer;
  padding: 6px 10px 6px 6px;
  width: fit-content;
  height: 40px;
  border: 0;
  overflow: hidden;
  position: relative;
  transition: var(--btn-transition);
}

.button-message:hover {
  height: 56px;
  padding: 8px 20px 8px 8px;
  background-color: var(--bg-hover-color);
  transition: var(--btn-transition);
}

.button-message:active {
  transform: scale(0.99);
}

.content-avatar {
  width: 30px;
  height: 30px;
  margin: 0;
  transition: var(--btn-transition);
  position: relative;
}

.button-message:hover .content-avatar {
  width: 40px;
  height: 40px;
}

.avatar {
  width: 100%;
  height: 100%;
  border-radius: 50%;
  overflow: hidden;
  background-color: var(--bg-color-sup);
}

.user-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.status-user {
  position: absolute;
  width: 6px;
  height: 6px;
  right: 1px;
  bottom: 1px;
  border-radius: 50%;
  outline: solid 2px var(--bg-color);
  background-color: var(--online-status);
  transition: var(--btn-transition);
  animation: active-status 2s ease-in-out infinite;
}

.button-message:hover .status-user {
  width: 10px;
  height: 10px;
  right: 1px;
  bottom: 1px;
  outline: solid 3px var(--bg-hover-color);
}

.notice-content {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: center;
  padding-left: 8px;
  text-align: initial;
  color: var(--text-color);
}

.username {
  letter-spacing: -6px;
  height: 0;
  opacity: 0;
  transform: translateY(-20px);
  transition: var(--btn-transition);
}

.user-id {
  font-size: 12px;
  letter-spacing: -6px;
  height: 0;
  opacity: 0;
  transform: translateY(10px);
  transition: var(--btn-transition);
}

.lable-message {
  display: flex;
  align-items: center;
  opacity: 1;
  transform: scaleY(1);
  transition: var(--btn-transition);
}

.button-message:hover .username {
  height: auto;
  letter-spacing: normal;
  opacity: 1;
  transform: translateY(0);
  transition: var(--btn-transition);
}

.button-message:hover .user-id {
  height: auto;
  letter-spacing: normal;
  opacity: 1;
  transform: translateY(0);
  transition: var(--btn-transition);
}

.button-message:hover .lable-message {
  height: 0;
  transform: scaleY(0);
  transition: var(--btn-transition);
}

.lable-message, .username {
  font-weight: 600;
}

.number-message {
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
  margin-left: 8px;
  font-size: 12px;
  width: 16px;
  height: 16px;
  background-color: var(--bg-color-sup);
  border-radius: 20px;
}

/*==============================================*/
@keyframes active-status {
  0% {
    background-color: var(--online-status);
  }

  33.33% {
    background-color: #93e200;
  }

  66.33% {
    background-color: #93e200;
  }

  100% {
    background-color: var(--online-status);
  }
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
      </div> <br> <br>
      <div class="container">

     <div class="row shadow-lg p- mb-5 bg-body-tertiary rou3nded">
    <div class="col-2">
        <div id="sidebar">
            <!-- Sidebar content here -->
        </div>
    </div>
      
    <div class="col-10" style="padding: 20px 20px 20px 10px;">
    <div class="row" style="height:40px">
    <div class="col-10"><div id="btn-message" class="button-message">
            <div class="content-avatar">
                <div class="status-user"></div>
                <div class="avatar">
                    <svg class="user-img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M12,12.5c-3.04,0-5.5,1.73-5.5,3.5s2.46,3.5,5.5,3.5,5.5-1.73,5.5-3.5-2.46-3.5-5.5-3.5Zm0-.5c1.66,0,3-1.34,3-3s-1.34-3-3-3-3,1.34-3,3,1.34,3,3,3Z"></path>
                    </svg>
                </div>
            </div>
            <div class="notice-content">
                <div class="username"><?php echo $UserName ?></div>
                <div class="lable-message"><?php echo $accountInfo['maquyen']?><span class="number-message"></span></div>
                <div class="user-id">ID: <?php echo $accountInfo['MaNV']?></div>
            </div>
        </div></div>
        <div class="col-2"><form method="post" action="logout.php">
            <button type="submit" class="btn btn-primary">Đăng xuất</button>
        </form></div>
    


    </div>
        
        
    


         
<div class="card-container">
   <div class="row " style="margin-top:20px">
   <div class="card-container">
        <div style="margin-left:100px" class="card">
            <div class="card-details">
                <img src="../image/money.gif" style="height: 64px; width: 64px;margin-left: 32px">
                <p class="text-title">Doanh thu</p>
                <p class="text-body"><b><?php echo number_format($totalThanhTien, 0, ',', '.'); ?> VNĐ</b></p>
            </div>
            <button type="button" class="card-button" onclick="window.location.href='../view/HoaDon_View.php'">More info</button>
        </div> 
    
   
        <div class="card">
            <div class="card-details">
                 <img src="../image/box-ezgif.com-resize.gif" style="height: 64px; width: 64px; margin-left: 27px">
                <p class="text-title">Đơn hàng</p>
                <p class="text-body"><b><?php  echo $totalHoaDon; ?></b></p>
            </div>
            <button type="button" class="card-button"   onclick="window.location.href='../view/HoaDon_View.php'" >More info</button>
        </div>
   
        <div class="card">
            <div class="card-details">
            <img src="../image/appraisal.gif" style="height: 64px; width: 64px;margin-left: 37px">
                <p class="text-title">Khách hàng</p>
                <p class="text-body"><b><?php echo $totalKH; ?></b></p>
            </div>
            <button type="button" class="card-button" onclick="window.location.href='../view/KhachHang_View.php'">More info</button>
        </div>
    
</div></div>

</div>
<br> <br>
<div style="width: 80%; margin: auto;">
        <canvas id="doanhThuLoiNhuanChart"></canvas>
    </div>
    <script>
                    document.addEventListener('DOMContentLoaded', (event) => {
                        const labels = <?php echo json_encode($labels); ?>;
                        const doanhThu = <?php echo json_encode($doanhThu); ?>;
                        const loiNhuan = <?php echo json_encode($loiNhuan); ?>;

                        const ctx = document.getElementById('doanhThuLoiNhuanChart').getContext('2d');
                        const chart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [
                                    {
                                        label: 'Doanh Thu',
                                        data: doanhThu,
                                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                        borderColor: 'rgba(54, 162, 235, 1)',
                                        borderWidth: 1
                                    },
                                    {
                                        label: 'Lợi Nhuận',
                                        data: loiNhuan,
                                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        borderWidth: 1
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    });
                </script>

   
          
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
