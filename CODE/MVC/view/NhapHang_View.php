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

$sql_phieunhap = "SELECT pd.MaPhieuNhap AS MaPhieuNhap ,pd.MaPhieuDat AS MaPhieuDat , pd.NgayNhap  AS NgayNhap , pd.TrangThai  AS TrangThai, pd.TongTien  AS TongTien , nv.TenNV  AS TenNV , pd.MaNV  AS MANV 
                 FROM phieunhap pd
                 JOIN nhanvien nv ON pd.MaNV = nv.MaNV";


$category_id = isset($_POST['category_id']) ? $_POST['category_id'] : null;
$order_by = isset($_POST['order_by']) ? $_POST['order_by'] : null;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
      if (isset($_POST['MaPhieuNhap']) && !empty($_POST['MaPhieuNhap']) && is_numeric($_POST['MaPhieuNhap'])) {
        $id = $_POST['MaPhieuNhap'];
        $sql_delete = "DELETE FROM phieunhap WHERE MaPhieuNhap=:id";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt_delete->execute()) {
            echo "Delete successful";
        } else {
            echo "Error deleting record";
        }
        } elseif (isset($_POST['btn_trangthai'])) {
            $phai = $_POST['btn_trangthai'];
            $sql_phieunhap .= " WHERE TrangThai = :phai";
        } elseif (isset($_POST['btn_sx'])) {
            $order_by = $_POST['btn_sx'] === 'desc' ? 'DESC' : 'ASC';
            $sql_phieunhap .= " ORDER BY MaPhieuNhap $order_by";
            // Add LIMIT clause if needed
        } elseif (isset($_POST['search_button'])) {
            $ten = isset($_POST['search_query']) ? '%' . $_POST['search_query'] . '%' : '';
            if (!empty($ten)) {
                $sql_phieunhap .= " WHERE NgayNhap LIKE :ten";
            }
            // Add LIMIT clause if needed
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

$stmt_phieunhap = $conn->prepare($sql_phieunhap);
if (isset($phai)) {
    $stmt_phieunhap->bindParam(':phai', $phai);
}
if (isset($ten)) {
    $stmt_phieunhap->bindParam(':ten', $ten);
}
$stmt_phieunhap->execute();
$phieunhap = $stmt_phieunhap->fetchAll();

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
    <title>Quản lý thông tin nhập hàng</title>
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
      </div> <br> <br>
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

    <h1>Quản lý nhập hàng</h1>

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
                <button class="btn btn-sm btn-outline-secondary" type="submit" name="btn_phai" value="Hoàn thành">Đã nhập</button>
                <button class="btn btn-sm btn-outline-secondary" type="submit" name="btn_phai" value="Chưa hoàn thành">Chưa hoàn thành</button>
            </div>
        </form>

            
          </div>

               
    </div>


    <a type="button"class="cta" href="../view/ThemPhieuNhapHang.php">Thêm mới</a>


    <table class="table">
    <thead>
        <tr>
            <th scope="col">Mã phiếu nhập</th>
            <th scope="col">Ngày nhập</th>
            <th scope="col">Nhân viên</th>
            <th scope="col">Mã phiếu đặt</th>
            <th scope="col">Tổng tiền</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody style="line-height: 40px; height: 40px;">
        <?php
        if (!empty($ten)) {
            foreach ($phieunhap as $pd) {
        ?>
                <tr style="font-size: 12px;">
                    <td><?php echo $pd['MaPhieuNhap']; ?></td>
                    <td><?php echo $pd['NgayNhap']; ?></td>
                    <td><?php echo $pd['TenNV']; ?></td>
                    <td><?php echo $pd['MaPhieuDat']; ?></td>
                    <td><?php echo $pd['TongTien']; ?></td>
                    <td>
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <button class="btn btn-outline-primary" type="button" name="btn_chitiet" value="<?php echo $pd['MaPhieuNhap']; ?>" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar<?php echo $pd['MaPhieuNhap']; ?>" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-chat-left-text" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M2 12.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5"/>
                                </svg>
                            </button>
                        </form>
                        <!-- Offcanvas for each PhieuNhap -->
                        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar<?php echo $pd['MaPhieuNhap']; ?>" aria-labelledby="offcanvasNavbarLabel">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Thông tin phiếu nhập</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <p>Mã phiếu nhập: <?php echo $pd['MaPhieuNhap']; ?></p>
                                <p>Ngày nhập: <?php echo $pd['NgayNhap']; ?></p>
                                <p>Nhân viên: <?php echo $pd['TenNV']; ?></p>
                                <!-- Thêm thông tin chi tiết từ cơ sở dữ liệu -->
                                <?php
                                // Câu truy vấn SQL để lấy chi tiết phiếu nhập
                                $sql_chitiet = "SELECT sp.TenSP, ctpn.SoLuong FROM chitietphieunhap ctpn INNER JOIN sanpham sp ON ctpn.MaSP  = sp.MaSP WHERE ctpn.MaPhieuNhap = :MaPhieuNhap";
                                $stmt_chitiet = $conn->prepare($sql_chitiet);
                                $stmt_chitiet->bindParam(':MaPhieuNhap', $pd['MaPhieuNhap']);
                                $stmt_chitiet->execute();
                                $chitietphieunhap = $stmt_chitiet->fetchAll();

                                if ($stmt_chitiet->rowCount() > 0) {
                                    foreach ($chitietphieunhap as $ctpn) {
                                ?>
                                        <p>Tên sản phẩm: <?php echo $ctpn['TenSP']; ?></p>
                                        <p>Số lượng: <?php echo $ctpn['SoLuong']; ?></p>
                                    <?php }
                                } else {
                                    echo "<p>Không có chi tiết nào cho phiếu nhập này.</p>";
                                }
                                    ?>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php
            }
        } elseif (!empty($category_id)) {
            foreach ($phieunhap as $pd) {
            ?>
                <tr style="font-size: 12px;">
                    <td><?php echo $pd['MaPhieuNhap']; ?></td>
                    <td><?php echo $pd['NgayNhap']; ?></td>
                    <td><?php echo $pd['TenNV']; ?></td>
                    <td><?php echo $pd['MaPhieuDat']; ?></td>
                    <td><?php echo $pd['TongTien']; ?></td>
                    <td>
                        <form method="post" action="QL_NhapHang.php">
                            <button class="btn btn-outline-primary" type="button" name="btn_chitiet" value="<?php echo $pd['MaPhieuNhap']; ?>" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar<?php echo $pd['MaPhieuNhap']; ?>" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-chat-left-text" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M2 12.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5"/>
                                </svg>
                            </button>
                        </form>
                        <!-- Offcanvas for each PhieuNhap -->
                        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar<?php echo $pd['MaPhieuNhap']; ?>" aria-labelledby="offcanvasNavbarLabel">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Thông tin phiếu nhập</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <p>Mã phiếu nhập: <?php echo $pd['MaPhieuNhap']; ?></p>
                                <p>Ngày nhập: <?php echo $pd['NgayNhap']; ?></p>
                                <p>Nhân viên: <?php echo $pd['TenNV']; ?></p>
                                <!-- Thêm thông tin chi tiết từ cơ sở dữ liệu -->
                                <?php
                                // Câu truy vấn SQL để lấy chi tiết phiếu nhập
                                $sql_chitiet = "SELECT sp.TenSP, ctpn.SoLuong FROM chitietphieunhap ctpn INNER JOIN sanpham sp ON ctpn.MaSP  = sp.MaSP WHERE ctpn.MaPhieuNhap = :MaPhieuNhap";
                                $stmt_chitiet = $conn->prepare($sql_chitiet);
                                $stmt_chitiet->bindParam(':MaPhieuNhap', $pd['MaPhieuNhap']);
                                $stmt_chitiet->execute();
                                $chitietphieunhap = $stmt_chitiet->fetchAll();

                                if ($stmt_chitiet->rowCount() > 0) {
                                    foreach ($chitietphieunhap as $ctpn) {
                                ?>
                                        <p>Tên sản phẩm: <?php echo $ctpn['TenSP']; ?></p>
                                        <p>Số lượng: <?php echo $ctpn['SoLuong']; ?></p>
                                    <?php }
                                } else {
                                    echo "<p>Không có chi tiết nào cho phiếu nhập này.</p>";
                                }
                                ?>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php
            }
        } elseif (!empty($order_by)) {
            foreach ($phieunhap as $pd) {
            ?>
                <tr style="font-size: 12px;">
                    <td><?php echo $pd['MaPhieuNhap']; ?></td>
                    <td><?php echo $pd['NgayNhap']; ?></td>
                    <td><?php echo $pd['TenNV']; ?></td>
                    <td><?php echo $pd['MaPhieuDat']; ?></td>
                    <td><?php echo $pd['TongTien']; ?></td>
                    <td>
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <button class="btn btn-outline-primary" type="button" name="btn_chitiet" value="<?php echo $pd['MaPhieuNhap']; ?>" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar<?php echo $pd['MaPhieuNhap']; ?>" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-chat-left-text" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M2 12.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5"/>
                                </svg>
                            </button>
                        </form>
                        <!-- Offcanvas for each PhieuNhap -->
                        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar<?php echo $pd['MaPhieuNhap']; ?>" aria-labelledby="offcanvasNavbarLabel">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Thông tin phiếu nhập</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <p>Mã phiếu nhập: <?php echo $pd['MaPhieuNhap']; ?></p>
                                <p>Ngày nhập: <?php echo $pd['NgayNhap']; ?></p>
                                <p>Nhân viên: <?php echo $pd['TenNV']; ?></p>
                                <!-- Thêm thông tin chi tiết từ cơ sở dữ liệu -->
                                <?php
                                // Câu truy vấn SQL để lấy chi tiết phiếu nhập
                                $sql_chitiet = "SELECT sp.TenSP, ctpn.SoLuong FROM chitietphieunhap ctpn INNER JOIN sanpham sp ON ctpn.MaSP  = sp.MaSP WHERE ctpn.MaPhieuNhap = :MaPhieuNhap";
                                $stmt_chitiet = $conn->prepare($sql_chitiet);
                                $stmt_chitiet->bindParam(':MaPhieuNhap', $pd['MaPhieuNhap']);
                                $stmt_chitiet->execute();
                                $chitietphieunhap = $stmt_chitiet->fetchAll();

                                if ($stmt_chitiet->rowCount() > 0) {
                                    foreach ($chitietphieunhap as $ctpn) {
                                ?>
                                        <p>Tên sản phẩm: <?php echo $ctpn['TenSP']; ?></p>
                                        <p>Số lượng: <?php echo $ctpn['SoLuong']; ?></p>
                                    <?php }
                                } else {
                                    echo "<p>Không có chi tiết nào cho phiếu nhập này.</p>";
                                }
                                ?>
                            </div>
                        </div>
                    </td>
                </tr>
        <?php
            }
        } else {
            foreach ($phieunhap as $pd) {
        ?>
                <tr style="font-size: 12px;">
                    <td><?php echo $pd['MaPhieuNhap']; ?></td>
                    <td><?php echo $pd['NgayNhap']; ?></td>
                    <td><?php echo $pd['TenNV']; ?></td>
                    <td><?php echo $pd['MaPhieuDat']; ?></td>
                    <td><?php echo $pd['TongTien']; ?></td>
                    <td>
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <button class="btn btn-outline-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar<?php echo $pd['MaPhieuNhap']; ?>" aria-controls="offcanvasNavbar" aria-label="Toggle navigation" id="btn_chitiet" name="btn_chitiet" value="<?php echo $pd['MaPhieuNhap'] ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-chat-left-text" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M2 12.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5"/>
                                </svg>
                            </button>
                        </form>
                        <!-- Offcanvas for each PhieuNhap -->
                        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar<?php echo $pd['MaPhieuNhap']; ?>" aria-labelledby="offcanvasNavbarLabel">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Thông tin phiếu nhập</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <p>Mã phiếu nhập: <?php echo $pd['MaPhieuNhap']; ?></p>
                                <p>Ngày nhập: <?php echo $pd['NgayNhap']; ?></p>
                                <p>Nhân viên: <?php echo $pd['TenNV']; ?></p>
                                <!-- Thêm thông tin chi tiết từ cơ sở dữ liệu -->
                                <?php
                                // Câu truy vấn SQL để lấy chi tiết phiếu nhập
                                $sql_chitiet = "SELECT sp.TenSP, ctpn.SoLuong FROM chitietphieunhap ctpn INNER JOIN sanpham sp ON ctpn.MaSP  = sp.MaSP WHERE ctpn.MaPhieuNhap = :MaPhieuNhap";
                                $stmt_chitiet = $conn->prepare($sql_chitiet);
                                $stmt_chitiet->bindParam(':MaPhieuNhap', $pd['MaPhieuNhap']);
                                $stmt_chitiet->execute();
                                $chitietphieunhap = $stmt_chitiet->fetchAll();

                                if ($stmt_chitiet->rowCount() > 0) {
                                    foreach ($chitietphieunhap as $ctpn) {
                                ?>
                                        <p>Tên sản phẩm: <?php echo $ctpn['TenSP']; ?></p>
                                        <p>Số lượng: <?php echo $ctpn['SoLuong']; ?></p>
                                    <?php }
                                } else {
                                    echo "<p>Không có chi tiết nào cho phiếu nhập này.</p>";
                                }
                                ?>
                            </div>
                        </div>
                    </td>
                </tr>
    <?php
            }
        }
    ?>
    </tbody>
    </table>
    </div>
    </div>
    </div>
    </div> </div>
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