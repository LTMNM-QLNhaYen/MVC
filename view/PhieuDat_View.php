<?php

require_once("../model/DB.php");
require_once("../controller/ChiTietPhieuDat_con.php");
require_once("../controller/PhieuDat_con.php");
require_once("../controller/HangSanXuat_con.php");
require_once("../controller/SanPham_con.php");

$conn = new DB();

include_once '../controller/TaiKhoanNV_con.php';
$taiKhoanController = new TaiKhoanNVController($conn);
session_start();
$UserName = $_SESSION['UserName']; 

if (!isset($_SESSION['UserName'])) {
  // Nếu không đăng nhập, chuyển hướng đến trang đăng nhập
  header("Location: Login_Admin.php");
  exit(); // Dừng kịch bản để chuyển hướng được thực hiện
}

//Thong tin user
$accountInfo = $taiKhoanController->getAccountInfo($UserName);

$sql_phieudat = "SELECT pd.MaPhieuDat AS MaPhieuDat , pd.NgayLap  AS NgayLap , pd.TrangThai  AS TrangThai, pd.MaHSX  AS MaHSX , hsx.TenHSX  AS TenHSX 
                 FROM phieudat pd
                 JOIN hangsanxuat hsx ON pd.MaHSX = hsx.MaHSX";


$category_id = isset($_POST['category_id']) ? $_POST['category_id'] : null;
$order_by = isset($_POST['order_by']) ? $_POST['order_by'] : null;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        if (isset($_POST['MaPhieuDat']) && !empty($_POST['MaPhieuDat']) && is_numeric($_POST['MaPhieuDat'])) {
            $id = $_POST['MaPhieuDat'];
            $sql_delete = "DELETE FROM phieudat WHERE MaPhieuDat=:id";
            $stmt_delete = $conn->prepare($sql_delete);
            $stmt_delete->bindParam(':id', $id, PDO::PARAM_INT);
            if ($stmt_delete->execute()) {
                echo "Delete successful";
            } else {
                echo "Error deleting record";
            }
        } elseif (isset($_POST['btn_trangthai'])) {
            $phai = $_POST['btn_trangthai'];
            $sql_phieudat .= " WHERE TrangThai = :phai";
        } elseif (isset($_POST['btn_sx'])) {
            $order_by = $_POST['btn_sx'] === 'desc' ? 'DESC' : 'ASC';
            $sql_phieudat .= " ORDER BY MaPhieuDat $order_by";
            // Add LIMIT clause if needed
        } elseif (isset($_POST['search_button'])) {
            $ten = isset($_POST['search_query']) ? '%' . $_POST['search_query'] . '%' : '';
            if (!empty($ten)) {
                $sql_phieudat .= " WHERE NgayLap LIKE :ten";
            }
            // Add LIMIT clause if needed
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

$stmt_phieudat = $conn->prepare($sql_phieudat);
if (isset($phai)) {
    $stmt_phieudat->bindParam(':phai', $phai);
}
if (isset($ten)) {
    $stmt_phieudat->bindParam(':ten', $ten);
}
$stmt_phieudat->execute();
$phieudat = $stmt_phieudat->fetchAll();





if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['btn_chitiet'])) {
      $gia_tri_mpd = $_POST['bpd'];
      
      $sql_chitietphieudat = "SELECT ctpd.MaSanPham AS MaSanPham, ctpd.SoLuong AS SoLuong, sp.TenSP AS TenSP
                              FROM chitietphieudat ctpd
                              JOIN sanpham sp ON ctpd.MaSanPham = sp.MaSP
                              WHERE ctpd.MaPhieuDat = :mpd";

      $stmt_chitietphieudat = $conn->prepare($sql_chitietphieudat);
      $stmt_chitietphieudat->bindParam(':mpd', $gia_tri_mpd);
      
      if (!$stmt_chitietphieudat->execute()) {
          // Xử lý khi có lỗi xảy ra trong truy vấn SQL
          $error = $stmt_chitietphieudat->errorInfo();
          echo "Lỗi SQL: " . $error[2];
      } else {
          // Kiểm tra xem có dữ liệu trả về không
          if ($stmt_chitietphieudat->rowCount() > 0) {
              $chitietphieudat = $stmt_chitietphieudat->fetchAll();
          } else {
              // Xử lý khi không có dữ liệu trả về
              echo "Không có chi tiết phiếu đặt nào được tìm thấy.";
          }
      }
  }
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
    <title>Quản lý thông tin phiếu đặt</title>
    <link rel="stylesheet" type="text/css" href="style.css">
<style>

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
.cta {
  align-items: center;
  appearance: none;
  background-color: #EEF2FF;
  border-radius: 8px;
  border-width: 2px;
  border-color: #536DFE;
  box-shadow: rgba(83, 109, 254, 0.2) 0 2px 4px, rgba(83, 109, 254, 0.15) 0 7px 13px -3px, #D6D6E7 0 -3px 0 inset;
  box-sizing: border-box;
  color: #536DFE;
  cursor: pointer;
  display: inline-flex;
  font-family: "JetBrains Mono", monospace;
  height: 45px;
  justify-content: center;
  line-height: 1;
  list-style: none;
  overflow: hidden;
  padding-left: 15px;
  padding-right: 15px;
  position: relative;
  text-align: center;
  text-decoration: none;
  transition: box-shadow 0.15s, transform 0.15s;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  white-space: nowrap;
  will-change: box-shadow, transform;
  font-size: 15px;
  margin-left:10px
}

.cta:focus {
  outline: none;
  box-shadow: #D6D6E7 0 0 0 1.5px inset, rgba(83, 109, 254, 0.4) 0 2px 4px, rgba(83, 109, 254, 0.3) 0 7px 13px -3px, #D6D6E7 0 -3px 0 inset;
}

.cta:hover {
  box-shadow: rgba(83, 109, 254, 0.3) 0 4px 8px, rgba(83, 109, 254, 0.2) 0 7px 13px -3px, #D6D6E7 0 -3px 0 inset;
  transform: translateY(-2px);
}

.cta:active {
  box-shadow: #D6D6E7 0 3px 7px inset;
  transform: translateY(2px);
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
    <h1>Quản lý đặt hàng</h1>

        <div class="row">
        <div class="navbar bg-body-tertiary" style="border-radius: 10px;">
        <div class="container-fluid">
            <form class="d-flex"  method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_query">
                <button class="btn btn-outline-success" type="submit" name="search_button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                    </svg>
                </button>
              
          </form>
          <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="padding: 0 0 0 20px;">
                <button class="btn btn-sm btn-outline-secondary" type="submit" name="btn_ShowAll">Tất cả</button>
                <button class="btn btn-sm btn-outline-secondary" type="submit" name="btn_sx" value="desc">Tăng dần</button>
                <button class="btn btn-sm btn-outline-secondary" type="submit" name="btn_sx" value="asc">Giảm dần</button>
                <button class="btn btn-sm btn-outline-secondary" type="submit" name="btn_phai" value="Hoàn thành">Hoàn thành</button>
                <button class="btn btn-sm btn-outline-secondary" type="submit" name="btn_phai" value="Chưa hoàn thành">Chưa hoàn thành</button>
            </div>
        </form>

            
          </div>

               
    </div>



<a  class="cta" type="button" href="../view/ThemPhieuDatHang.php">Thêm mới</a>


<table class="table">
<thead>
<tr>
<th scope="col">Mã phiếu đặt</th>
<th scope="col">Ngày lập</th>
<th scope="col">Trạng thái</th>
<th scope="col">Hãng sản xuất</th>
<th scope="col"></th>
</tr>
</tr>
</thead>
<tbody style ="line-height: 40px; height: 40px;">
<?php


    if(!empty($ten)) 
    {
      foreach($phieudat as $pd)
    {

    ?>
    <tr style="font-size: 12px;">
        <td><?php echo $pd['MaPhieuDat']; ?></td>
        <td><?php echo $pd['NgayLap']; ?></td>
        <td><?php echo $pd['TrangThai']; ?></td>
        <td><?php echo $pd['TenHSX']; ?></td>
        <td>
            <button class="btn btn-outline-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar<?php echo $pd['MaPhieuDat']; ?>" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                Xem chi tiết
            </button>
        </td>
    </tr>
    <!-- Offcanvas for each PhieuDat -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar<?php echo $pd['MaPhieuDat']; ?>" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Thông tin phiếu đặt</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <p>Mã phiếu đặt: <?php echo $pd['MaPhieuDat']; ?></p>
            <p>Ngày đặt: <?php echo $pd['NgayLap']; ?></p>
            <p>Hãng sản xuất: <?php echo $pd['TenHSX']; ?></p>
            <?php
            // Câu truy vấn SQL để lấy chi tiết phiếu đặt
            $sql_chitiet = "SELECT sp.TenSP, ctpd.SoLuong FROM chitietphieudat ctpd INNER JOIN sanpham sp ON ctpd.MaSanPham = sp.MaSP WHERE ctpd.MaPhieuDat = :MaPhieuDat";
            $stmt_chitiet = $conn->prepare($sql_chitiet);
            $stmt_chitiet->bindParam(':MaPhieuDat', $pd['MaPhieuDat']);
            $stmt_chitiet->execute();
            $chitietphieudat = $stmt_chitiet->fetchAll();

            if ($stmt_chitiet->rowCount() > 0) {
                foreach ($chitietphieudat as $ctpd) {
                    ?>
                    <p>Tên sản phẩm: <?php echo $ctpd['TenSP']; ?></p>
                    <p>Số lượng: <?php echo $ctpd['SoLuong']; ?></p>
                <?php }
            } else {
                echo "<p>Không có chi tiết nào cho phiếu đặt này.</p>";
            }
            ?>
        </div>
    </div>

   <?php
      }
  } elseif(!empty($category_id)) 
  {
    foreach($phieudat as $pd)
    {

    ?>
   <tr style="font-size: 12px;">
        <td><?php echo $pd['MaPhieuDat']; ?></td>
        <td><?php echo $pd['NgayLap']; ?></td>
        <td><?php echo $pd['TrangThai']; ?></td>
        <td><?php echo $pd['TenHSX']; ?></td>
        <td>
            <button class="btn btn-outline-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar<?php echo $pd['MaPhieuDat']; ?>" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                Xem chi tiết
            </button>
        </td>
    </tr>
    <!-- Offcanvas for each PhieuDat -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar<?php echo $pd['MaPhieuDat']; ?>" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Thông tin phiếu đặt</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <p>Mã phiếu đặt: <?php echo $pd['MaPhieuDat']; ?></p>
            <p>Ngày đặt: <?php echo $pd['NgayLap']; ?></p>
            <p>Hãng sản xuất: <?php echo $pd['TenHSX']; ?></p>
            <?php
            // Câu truy vấn SQL để lấy chi tiết phiếu đặt
            $sql_chitiet = "SELECT sp.TenSP, ctpd.SoLuong FROM chitietphieudat ctpd INNER JOIN sanpham sp ON ctpd.MaSanPham = sp.MaSP WHERE ctpd.MaPhieuDat = :MaPhieuDat";
            $stmt_chitiet = $conn->prepare($sql_chitiet);
            $stmt_chitiet->bindParam(':MaPhieuDat', $pd['MaPhieuDat']);
            $stmt_chitiet->execute();
            $chitietphieudat = $stmt_chitiet->fetchAll();

            if ($stmt_chitiet->rowCount() > 0) {
                foreach ($chitietphieudat as $ctpd) {
                    ?>
                    <p>Tên sản phẩm: <?php echo $ctpd['TenSP']; ?></p>
                    <p>Số lượng: <?php echo $ctpd['SoLuong']; ?></p>
                <?php }
            } else {
                echo "<p>Không có chi tiết nào cho phiếu đặt này.</p>";
            }
            ?>
        </div>
    </div>
   <?php
       }
      } 
      
      elseif(!empty($order_by)) 
      {
        foreach($phieudat as $pd)
        {

        ?>
       <tr style="font-size: 12px;">
        <td><?php echo $pd['MaPhieuDat']; ?></td>
        <td><?php echo $pd['NgayLap']; ?></td>
        <td><?php echo $pd['TrangThai']; ?></td>
        <td><?php echo $pd['TenHSX']; ?></td>
        <td>
            <button class="btn btn-outline-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar<?php echo $pd['MaPhieuDat']; ?>" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                Xem chi tiết
            </button>
        </td>
    </tr>
    <!-- Offcanvas for each PhieuDat -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar<?php echo $pd['MaPhieuDat']; ?>" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Thông tin phiếu đặt</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <p>Mã phiếu đặt: <?php echo $pd['MaPhieuDat']; ?></p>
            <p>Ngày đặt: <?php echo $pd['NgayLap']; ?></p>
            <p>Hãng sản xuất: <?php echo $pd['TenHSX']; ?></p>
            <?php
            // Câu truy vấn SQL để lấy chi tiết phiếu đặt
            $sql_chitiet = "SELECT sp.TenSP, ctpd.SoLuong FROM chitietphieudat ctpd INNER JOIN sanpham sp ON ctpd.MaSanPham = sp.MaSP WHERE ctpd.MaPhieuDat = :MaPhieuDat";
            $stmt_chitiet = $conn->prepare($sql_chitiet);
            $stmt_chitiet->bindParam(':MaPhieuDat', $pd['MaPhieuDat']);
            $stmt_chitiet->execute();
            $chitietphieudat = $stmt_chitiet->fetchAll();

            if ($stmt_chitiet->rowCount() > 0) {
                foreach ($chitietphieudat as $ctpd) {
                    ?>
                    <p>Tên sản phẩm: <?php echo $ctpd['TenSP']; ?></p>
                    <p>Số lượng: <?php echo $ctpd['SoLuong']; ?></p>
                <?php }
            } else {
                echo "<p>Không có chi tiết nào cho phiếu đặt này.</p>";
            }
            ?>
        </div>
    </div>
       <?php
       }
          }else 
  
          {  foreach($phieudat as $pd)
            {

            ?>
           <tr style="font-size: 12px;">
        <td><?php echo $pd['MaPhieuDat']; ?></td>
        <td><?php echo $pd['NgayLap']; ?></td>
        <td><?php echo $pd['TrangThai']; ?></td>
        <td><?php echo $pd['TenHSX']; ?></td>
        <td>
            <button class="btn btn-outline-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar<?php echo $pd['MaPhieuDat']; ?>" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                Xem chi tiết
            </button>
        </td>
    </tr>
    <!-- Offcanvas for each PhieuDat -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar<?php echo $pd['MaPhieuDat']; ?>" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Thông tin phiếu đặt</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <p>Mã phiếu đặt: <?php echo $pd['MaPhieuDat']; ?></p>
            <p>Ngày đặt: <?php echo $pd['NgayLap']; ?></p>
            <p>Hãng sản xuất: <?php echo $pd['TenHSX']; ?></p>
            <?php
            // Câu truy vấn SQL để lấy chi tiết phiếu đặt
            $sql_chitiet = "SELECT sp.TenSP, ctpd.SoLuong FROM chitietphieudat ctpd INNER JOIN sanpham sp ON ctpd.MaSanPham = sp.MaSP WHERE ctpd.MaPhieuDat = :MaPhieuDat";
            $stmt_chitiet = $conn->prepare($sql_chitiet);
            $stmt_chitiet->bindParam(':MaPhieuDat', $pd['MaPhieuDat']);
            $stmt_chitiet->execute();
            $chitietphieudat = $stmt_chitiet->fetchAll();

            if ($stmt_chitiet->rowCount() > 0) {
                foreach ($chitietphieudat as $ctpd) {
                    ?>
                    <p>Tên sản phẩm: <?php echo $ctpd['TenSP']; ?></p>
                    <p>Số lượng: <?php echo $ctpd['SoLuong']; ?></p>
                <?php }
            } else {
                echo "<p>Không có chi tiết nào cho phiếu đặt này.</p>";
            }
            ?>
        </div>
    </div>
           <?php
              }
    
  }
  ?>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>



    
    


</td>


</tbody>
</table>  </div>
    </div>  </div>
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
