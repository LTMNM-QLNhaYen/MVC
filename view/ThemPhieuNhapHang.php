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


$maNV=$accountInfo['MaNV'];










$sql_chi_tiet_phieu_dat = "SELECT pd.MaPhieuDat, pd.MaSanPham, pd.SoLuong, s.TenSP, s.DonViTinh
FROM ChiTietPhieuDat pd
INNER JOIN SanPham s ON pd.MaSanPham = s.MaSP";
$stmt_chi_tiet_phieu_dat = $conn->prepare($sql_chi_tiet_phieu_dat);
$stmt_chi_tiet_phieu_dat->execute();
$result_chi_tiet_phieu_dat = $stmt_chi_tiet_phieu_dat->fetchAll(PDO::FETCH_ASSOC);

$products_by_phieudat = [];
if (!empty($result_chi_tiet_phieu_dat)) {
foreach ($result_chi_tiet_phieu_dat as $product) {
$phieudat_id = $product['MaPhieuDat'];
if (!isset($products_by_phieudat[$phieudat_id])) {
$products_by_phieudat[$phieudat_id] = [];
}
$products_by_phieudat[$phieudat_id][] = $product;
}
}

$sql_phieudat = "SELECT pd.MaPhieuDat AS MaPhieuDat, pd.NgayLap AS NgayLap, pd.TrangThai AS TrangThai, pd.MaHSX AS MaHSX, hsx.TenHSX AS TenHSX 
FROM phieudat pd 
JOIN hangsanxuat hsx ON pd.MaHSX = hsx.MaHSX 
WHERE pd.TrangThai = 'Chưa hoàn thành'";

// Xử lý các thao tác POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Xử lý sắp xếp
if (isset($_POST['btn_sx'])) {
$order_by = $_POST['btn_sx'] === 'desc' ? 'DESC' : 'ASC';
$sql_phieudat .= " ORDER BY MaPhieuDat $order_by";
} elseif (isset($_POST['search_button'])) {
$ten = isset($_POST['search_query']) ? '%' . $_POST['search_query'] . '%' : '';
if (!empty($ten)) {
$sql_phieudat .= " WHERE NgayLap LIKE :ten";
}
}
}

$stmt_phieudat = $conn->prepare($sql_phieudat);
if (isset($ten)) {
$stmt_phieudat->bindParam(':ten', $ten);
}
$stmt_phieudat->execute();
$phieudat = $stmt_phieudat->fetchAll();

// Xử lý thêm phiếu nhập hàng
if (isset($_POST['btn_them'])) {
    // Kiểm tra dữ liệu từ form
    if (isset($_POST['btn_pd'], $_POST['txt_masp'], $_POST['txt_soluong'], $_POST['txt_gia'])) {
        // Lấy thông tin chi tiết về số lượng đã đặt của mỗi sản phẩm trong mỗi phiếu đặt
        $maPD = $_POST['btn_pd'];
        $sql_soluong_dadat = "SELECT pd.MaSanPham, SUM(pd.SoLuong) AS SoLuongDaDat
                              FROM ChiTietPhieuDat pd
                              WHERE pd.MaPhieuDat = ?
                              GROUP BY pd.MaSanPham";
        $stmt_soluong_dadat = $conn->prepare($sql_soluong_dadat);
        $stmt_soluong_dadat->execute([$maPD]);
        $result_soluong_dadat = $stmt_soluong_dadat->fetchAll(PDO::FETCH_ASSOC);

        // Tạo một mảng để lưu số lượng đã đặt của mỗi sản phẩm
        $soluong_dadat_by_masp = [];
        foreach ($result_soluong_dadat as $item) {
            $masp = $item['MaSanPham'];
            $soluong_dadat = $item['SoLuongDaDat'];
            $soluong_dadat_by_masp[$masp] = $soluong_dadat;
        }

        // Kiểm tra số lượng nhập so với số lượng đã đặt
        $co_loi = false;
        foreach ($_POST['txt_masp'] as $index => $maSP) {
            $soluong_nhap = intval($_POST['txt_soluong'][$index]);
            $soluong_dadat = isset($soluong_dadat_by_masp[$maSP]) ? $soluong_dadat_by_masp[$maSP] : 0;
            if ($soluong_nhap > $soluong_dadat) {
                // Số lượng nhập vượt quá số lượng đã đặt
                $co_loi = true;
                echo "Số lượng nhập của sản phẩm có mã " . $maSP . " vượt quá số lượng đã đặt ($soluong_dadat) của phiếu đặt có mã $maPD <br>";
            }
        }

        // Nếu không có lỗi, thêm phiếu nhập hàng vào cơ sở dữ liệu
        if (!$co_loi) {
            $tt = 0; // Giả sử đây là một giá trị tạm thời cho tổng tiền
            $date = date("Y-m-d");
            $maPD = $_POST['btn_pd'];

            // Kiểm tra tồn tại của MaPhieuDat trong bảng phieudat
            $sql_check_phieudat = "SELECT COUNT(*) AS count FROM phieudat WHERE MaPhieuDat = ?";
            $stmt_check_phieudat = $conn->prepare($sql_check_phieudat);
            $stmt_check_phieudat->execute([$maPD]);
            $count = $stmt_check_phieudat->fetchColumn();

            if ($count > 0) {
                // MaPhieuDat tồn tại trong bảng phieudat, tiếp tục chèn dữ liệu vào bảng phieunhap
                $sql_insert_phieunhap = "INSERT INTO phieunhap (MaNV, NgayNhap, MaPhieuDat, TongTien, TrangThai) VALUES (?, ?, ?, ?, 'Đã nhập')";
                $stmt_insert_phieunhap = $conn->prepare($sql_insert_phieunhap);
                $stmt_insert_phieunhap->execute([$maNV,$date, $maPD, $tt]);

                $lastInsertedId = $conn->getConnection()->lastInsertId();

                // Inserting into ChiTietPhieuNhap table
                foreach ($_POST['txt_masp'] as $index => $maSP) {
                    $gia = intval($_POST['txt_gia'][$index]);
                    $quantity = intval($_POST['txt_soluong'][$index]);
                    $thanhtien = $gia * $quantity;

                    if (!empty($quantity)) {
                        $sql_insert_chitiet = "INSERT INTO chitietphieunhap (MaPhieuNhap, MaSP, SoLuong, GiaNhap, ThanhTien) VALUES (?, ?, ?, ?, ?)";
                        $stmt_insert_chitiet = $conn->prepare($sql_insert_chitiet);
                        $stmt_insert_chitiet->execute([$lastInsertedId, $maSP, $quantity, $gia, $thanhtien]);
                    }
                }
            } else {
                // MaPhieuDat không tồn tại trong bảng phieudat, xử lý lỗi hoặc thông báo lỗi
                echo "MaPhieuDat không tồn tại trong bảng phieudat!";
                // Thực hiện hành động phù hợp với logic ứng dụng của bạn, ví dụ: hiển thị thông báo lỗi
            }
        }
    } else {
        // Dữ liệu từ form không đầy đủ
        echo "Dữ liệu từ form không đầy đủ!";
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

      </div>
  </form>

      
    </div>
</div>
    <div class="container mt-5">
    <h4>Thêm phiếu nhập hàng</h4>
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
              { ?>
                      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" name="add_PD">
          <?php foreach ($phieudat as $p) { ?>
              <tr style="font-size: 12px;">
                  <td><?php echo $p['MaPhieuDat']; ?></td>
                  <td><?php echo $p['NgayLap']; ?></td>
                  <td><?php echo $p['TrangThai']; ?></td>
                  <td><?php echo $p['TenHSX']; ?></td>
                  <td>
                      <button type="button" name="btn_pd" class="btn btn-outline-warning" value="<?php echo $p['MaPhieuDat']; ?>" data-bs-toggle="modal" data-bs-target="#productModal_<?php echo $p['MaPhieuDat']; ?>">
                          <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-archive" viewBox="0 0 16 16">
                              <path d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5zm13-3H1v2h14zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
                          </svg>
                      </button>
                  </td>
              </tr>

              <!-- Product Modal -->
              <div class="modal fade custom-modal-width" id="productModal_<?php echo $p['MaPhieuDat']; ?>" tabindex="-1" aria-labelledby="productModalLabel_<?php echo $p['MaPhieuDat']; ?>" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="productModalLabel_<?php echo $p['MaPhieuDat']; ?>"><?php echo $p['TenHSX']; ?></h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                          <div class="row row-cols-4">
                              <input type="hidden" name="btn_pd" value="<?php echo $p['MaPhieuDat']; ?>">
                              <?php foreach ($products_by_phieudat[$p['MaPhieuDat']] as $product_pd) { ?>
                                  <div class="card" style="width: 15rem; margin: 5px;">
                                      <div class="card-body">
                                          <h5 class="card-title"><?php echo $product_pd['TenSP']; ?></h5>
                                          <p class="card-text">Đơn vị tính: <span style="color: red;"><?php echo $product_pd['DonViTinh']; ?></span></p>
                                          <input type="hidden" name="txt_masp[]" value="<?php echo $product_pd['MaSanPham']; ?>">
                                          <input class="form-control" type="number" name="txt_soluong[]" min="0" placeholder="Số lượng nhập" required>
                                          <input class="form-control" type="number" name="txt_gia[]" min="0" placeholder="Đơn giá" required>
                                      </div>
                                  </div>
                              <?php } ?>
                          </div>
                          </div>
                      
                      
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                              <button type="submit" class="btn btn-primary" name="btn_them">Lập phiếu nhập</button>
                          </div>
                      </div>
                  </div>
              </div>
          <?php } ?>
      </form>

              
              <?php }}


          
         
              
              elseif(!empty($order_by)) 
              
                { ?>
                       <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" name="add_PD">
          <?php foreach ($phieudat as $p) { ?>
              <tr style="font-size: 12px;">
                  <td><?php echo $p['MaPhieuDat']; ?></td>
                  <td><?php echo $p['NgayLap']; ?></td>
                  <td><?php echo $p['TrangThai']; ?></td>
                  <td><?php echo $p['TenHSX']; ?></td>
                  <td>
                      <button type="button" name="btn_pd" class="btn btn-outline-warning" value="<?php echo $p['MaPhieuDat']; ?>" data-bs-toggle="modal" data-bs-target="#productModal_<?php echo $p['MaPhieuDat']; ?>">
                          <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-archive" viewBox="0 0 16 16">
                              <path d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5zm13-3H1v2h14zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
                          </svg>
                      </button>
                  </td>
              </tr>

              <!-- Product Modal -->
              <div class="modal fade custom-modal-width" id="productModal_<?php echo $p['MaPhieuDat']; ?>" tabindex="-1" aria-labelledby="productModalLabel_<?php echo $p['MaPhieuDat']; ?>" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="productModalLabel_<?php echo $p['MaPhieuDat']; ?>"><?php echo $p['TenHSX']; ?></h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                          <div class="row row-cols-4">
                              <input type="hidden" name="btn_pd" value="<?php echo $p['MaPhieuDat']; ?>">
                              <?php foreach ($products_by_phieudat[$p['MaPhieuDat']] as $product_pd) { ?>
                                  <div class="card" style="width: 15rem; margin: 5px;">
                                      <div class="card-body">
                                          <h5 class="card-title"><?php echo $product_pd['TenSP']; ?></h5>
                                          <p class="card-text">Đơn vị tính: <span style="color: red;"><?php echo $product_pd['DonViTinh']; ?></span></p>
                                          <input type="hidden" name="txt_masp[]" value="<?php echo $product_pd['MaSanPham']; ?>">
                                          <input class="form-control" type="number" name="txt_soluong[]" placeholder="Số lượng nhập">
                                          <input class="form-control" type="number" name="txt_gia[]" placeholder="Đơn giá">
                                      </div>
                                  </div>
                              <?php } ?>
                          </div>
                          </div>
                      
                      
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                              <button type="submit" class="btn btn-primary" name="btn_them">Lập phiếu nhập</button>
                          </div>
                      </div>
                  </div>
              </div>
          <?php } ?>
      </form>

                
                <?php } 
                  else 
          { ?>
              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" name="add_PD">
          <?php foreach ($phieudat as $p) { ?>
              <tr style="font-size: 12px;">
                  <td><?php echo $p['MaPhieuDat']; ?></td>
                  <td><?php echo $p['NgayLap']; ?></td>
                  <td><?php echo $p['TrangThai']; ?></td>
                  <td><?php echo $p['TenHSX']; ?></td>
                  <td>
                      <button type="button" name="btn_pd" class="btn btn-outline-warning" value="<?php echo $p['MaPhieuDat']; ?>" data-bs-toggle="modal" data-bs-target="#productModal_<?php echo $p['MaPhieuDat']; ?>">
                          <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-archive" viewBox="0 0 16 16">
                              <path d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5zm13-3H1v2h14zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
                          </svg>
                      </button>
                  </td>
              </tr>

              <!-- Product Modal -->
              <div class="modal fade custom-modal-width" id="productModal_<?php echo $p['MaPhieuDat']; ?>" tabindex="-1" aria-labelledby="productModalLabel_<?php echo $p['MaPhieuDat']; ?>" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="productModalLabel_<?php echo $p['MaPhieuDat']; ?>"><?php echo $p['TenHSX']; ?></h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                          <div class="row row-cols-4">
                              <input type="hidden" name="btn_pd" value="<?php echo $p['MaPhieuDat']; ?>">
                              <?php foreach ($products_by_phieudat[$p['MaPhieuDat']] as $product_pd) { ?>
                                  <div class="card" style="width: 15rem; margin: 5px;">
                                      <div class="card-body">
                                          <h5 class="card-title"><?php echo $product_pd['TenSP']; ?></h5>
                                          <p class="card-text">Đơn vị tính: <span style="color: red;"><?php echo $product_pd['DonViTinh']; ?></span></p>
                                          <input type="hidden" name="txt_masp[]" value="<?php echo $product_pd['MaSanPham']; ?>">
                                          <input class="form-control" type="number" name="txt_soluong[]" placeholder="Số lượng nhập">
                                          <input class="form-control" type="number" name="txt_gia[]" placeholder="Đơn giá">
                                      </div>
                                  </div>
                              <?php } ?>
                          </div>
                          </div>
                      
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                              <button type="submit" class="btn btn-primary" name="btn_them">Lập phiếu nhập</button>
                          </div>
                      </div>
                  </div>
              </div>
          <?php } ?>
      </form>


        
        <?php } ?>
       

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>

       

            
            
    
    
    </td>
    

  </tbody>
</table>
</div>
  

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
