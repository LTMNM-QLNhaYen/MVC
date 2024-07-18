<?php
include("../model/DB.php");


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

$sql_hsx = "SELECT MaHSX, TenHSX FROM hangsanxuat";
$stmt_hsx = $conn->prepare($sql_hsx);
$stmt_hsx->execute();
$result_hsx = $stmt_hsx->fetchAll(PDO::FETCH_ASSOC);

$sql_sp_all = "SELECT s.MaSP, s.TenSP, s.DonViTinh, c.MaHSX, h.TenHSX
               FROM sanpham s
               INNER JOIN chitiet_sanpham_hangsanxuat c ON s.MaSP = c.MaSP
               INNER JOIN hangsanxuat h ON c.MaHSX = h.MaHSX";
$stmt_sp_all = $conn->prepare($sql_sp_all);
$stmt_sp_all->execute();
$result_sp_all = $stmt_sp_all->fetchAll(PDO::FETCH_ASSOC);

$products_by_manufacturer = [];
foreach ($result_sp_all as $product) {
    $manufacturer_id = $product['MaHSX'];
    if (!isset($products_by_manufacturer[$manufacturer_id])) {
        $products_by_manufacturer[$manufacturer_id] = [];
    }
    $products_by_manufacturer[$manufacturer_id][] = $product;
}


if (isset($_POST['btn_them'])) {
  // Kiểm tra xem dữ liệu từ form có tồn tại không
  if (isset($_POST['btn_hsx']) && isset($_POST['txt_masp']) && isset($_POST['txt_soluong'])) {
      // Lấy thông tin từ form
      $hxs = $_POST['btn_hsx'];
      $date = date("Y-m-d");

      // Thêm phiếu đặt vào cơ sở dữ liệu
      $sql_insert_phieudat = "INSERT INTO phieudat (NgayLap, TrangThai, MaHSX) VALUES (?, 'Chưa hoàn thành', ?)";
      $stmt_insert_phieudat = $conn->prepare($sql_insert_phieudat);
      $stmt_insert_phieudat->execute([$date, $hxs]);

      // Lấy ID của phiếu đặt vừa được thêm vào
      $lastInsertedId = $conn->getConnection()->lastInsertId();

      // Thêm chi tiết phiếu đặt (sản phẩm và số lượng) vào cơ sở dữ liệu
      foreach ($_POST['txt_masp'] as $index => $maSP) {
          $quantity = $_POST['txt_soluong'][$index];
          if (!empty($quantity)) {
              $sql_insert_chitiet = "INSERT INTO chitietphieudat (MaPhieuDat, MaSanPham, SoLuong) VALUES (?, ?, ?)";
              $stmt_insert_chitiet = $conn->prepare($sql_insert_chitiet);
              $stmt_insert_chitiet->execute([$lastInsertedId, $maSP, $quantity]);
          }
      }
  } else {
      // Xử lý khi không có dữ liệu gửi từ form
      echo "Dữ liệu từ form không tồn tại!";
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
    <title>Quản lý thông tin khách hàng</title>
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
</style>

  </head>
  <body>
    
      <div class="row">
        <div class="col-md-8"></div>
        <div class="col-6 col-md-4"></div>
      </div>

      <div class="row">
        <div id="menu"></div>
      </div> <br><br>
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

         
  <div class="container mt-5">
    <h4>Thêm phiếu đặt hàng</h4>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" name="add_PD">
        <div style="margin: 10px 10px 10px 0">
            <?php foreach ($products_by_manufacturer as $manufacturer_id => $products) { ?>
              <button type="button" id="btn_hsx_<?php echo $manufacturer_id; ?>" class="btn btn-outline-info manufacturerButton" value="<?php echo $manufacturer_id; ?>" data-bs-toggle="modal" data-bs-target="#productModal_<?php echo $manufacturer_id; ?>">
    <?php echo $products[0]['TenHSX']; ?>
</button>


            <?php } ?>
        </div>
       

        <!-- Product Modals -->
        <?php foreach ($products_by_manufacturer as $manufacturer_id => $products) { ?>
          <div class="modal fade custom-modal-width" id="productModal_<?php echo $manufacturer_id; ?>" tabindex="-1" aria-labelledby="productModalLabel_<?php echo $manufacturer_id; ?>" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" >
                    <div class="modal-content">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" name="add_PD">

                        <div class="modal-header" >
                            <h5 class="modal-title" id="productModalLabel_<?php echo $manufacturer_id; ?>"><?php echo $products[0]['TenHSX']; ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <input type="hidden" name="btn_hsx" value="<?php echo $manufacturer_id; ?>">

                            <div class="row row-cols-4" id="productList_<?php echo $manufacturer_id; ?>">
                                <?php foreach ($products as $product) { ?>
                                    <div class="card" style="width: 15rem; margin: 5px;" >
                                        <div class="card-body">
                                        
                                            <h5 class="card-title" ><?php echo $product['TenSP']; ?></h5>
                                            <p class="card-text">Đơn vị tính : <span style="color: red;"><?php echo $product['DonViTinh']; ?></span></p>
                                            <input type="hidden" name="txt_masp[]" value="<?php echo $product['MaSP']; ?>">
                                            <input class="form-control" type="number" name="txt_soluong[]" min="0" placeholder="Số lượng đặt" required>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                            <button type="submit" class="btn btn-primary" name="btn_them">Lập phiếu đặt</button>
                        </div>
                    </div>
                    </form>

                </div>
            </div>
        <?php } ?>
    </form>
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
