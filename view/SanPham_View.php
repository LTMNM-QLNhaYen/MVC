<?php 
include_once '../model/DB.php';
include_once '../controller/SanPham_con.php';
include_once '../controller/TaiKhoanNV_con.php';

$db = new DB();
$sanPhamController = new SanPhamController($db);


$taiKhoanNVController = new TaiKhoanNVController($db);

session_start();
$UserName = $_SESSION['UserName']; 

if (!isset($_SESSION['UserName'])) {
  // Nếu không đăng nhập, chuyển hướng đến trang đăng nhập
  header("Location: Login_Admin.php");
  exit(); // Dừng kịch bản để chuyển hướng được thực hiện
}

//Thong tin user
$accountInfo = $taiKhoanNVController->getAccountInfo($UserName);

// Add new product
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add-product-btn'])) {
  if (
    isset($_POST['TenSP']) && isset($_POST['DonViTinh']) && isset($_POST['GiaBan']) &&
    isset($_POST['GiaNhap']) && isset($_POST['TinhTrang']) && isset($_POST['MoTa']) &&
    isset($_POST['ThongTin']) && isset($_POST['MaLoai']) && isset($_POST['TonKho'])
) {
    // Process file upload logic
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../image/sanpham/';
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            echo "File is valid, and was successfully uploaded.\n";
            $imageUrl = basename($_FILES['image']['name']); // Set the image URL after successful upload
        } else {
            echo "Upload failed";
        }
    } else {
        echo "Vui lòng chọn một hình ảnh.";
    }

    // Continue with database insertion logic only if all required fields are set and image upload is successful
    if (isset($imageUrl)) {
        
      
      $tenSP = $_POST['TenSP'];
      $donViTinh = $_POST['DonViTinh'];
      $giaBan = $_POST['GiaBan'];
      $giaNhap = $_POST['GiaNhap'];
      $tinhTrang = $_POST['TinhTrang'];
      $moTa = $_POST['MoTa'];
      $thongTin = $_POST['ThongTin'];
      $Url = $imageUrl;
      $maLoai = $_POST['MaLoai'];
      $tonKho = $_POST['TonKho'];
      $maHSX = $_POST['MaHSX']; // Manufacturer ID
      $sql_check_existing = "SELECT COUNT(*) FROM SanPham WHERE TenSP = :TenSP";
      $stmt_check_existing = $db->prepare($sql_check_existing);
      $stmt_check_existing->bindParam(':TenSP', $tenSP);
      $stmt_check_existing->execute();
      $count = $stmt_check_existing->fetchColumn();
      
      if ($count > 0) {
          echo "Product with the same name already exists.";
      } else {
      // Insert into the SanPham table to get the generated MaSP
      $sql_insert_product = "INSERT INTO SanPham (TenSP, DonViTinh, GiaBan, GiaNhap, TinhTrang, MoTa, ThongTin, ImageUrl, MaLoai, TonKho) VALUES (:TenSP, :DonViTinh, :GiaBan, :GiaNhap, :TinhTrang, :MoTa, :ThongTin, :ImageUrl, :MaLoai, :TonKho)";
      $stmt_insert_product = $db->prepare($sql_insert_product);
      $stmt_insert_product->bindParam(':TenSP', $tenSP);
      $stmt_insert_product->bindParam(':DonViTinh', $donViTinh);
      $stmt_insert_product->bindParam(':GiaBan', $giaBan);
      $stmt_insert_product->bindParam(':GiaNhap', $giaNhap);
      $stmt_insert_product->bindParam(':TinhTrang', $tinhTrang);
      $stmt_insert_product->bindParam(':MoTa', $moTa);
      $stmt_insert_product->bindParam(':ThongTin', $thongTin);
      $stmt_insert_product->bindParam(':ImageUrl', $Url);
      $stmt_insert_product->bindParam(':MaLoai', $maLoai);
      $stmt_insert_product->bindParam(':TonKho', $tonKho);
      $stmt_insert_product->execute();

      // Retrieve the generated MaSP
      $maSP = $db->getPdo()->lastInsertId();

      // Insert into the ChiTiet_SanPham_HangSanXuat table
      $sql_insert_relationship = "INSERT INTO ChiTiet_SanPham_HangSanXuat (MaSP, MaHSX) VALUES (:MaSP, :MaHSX)";
      $stmt_insert_relationship = $db->prepare($sql_insert_relationship);
      $stmt_insert_relationship->bindParam(':MaSP', $maSP);
      $stmt_insert_relationship->bindParam(':MaHSX', $maHSX);
      $stmt_insert_relationship->execute();
      }
    } else {
        echo "Vui lòng điền đầy đủ thông tin!";
    }
}}

// Fetch all products
$sanPham = $sanPhamController->read();

// Delete a product
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete-product-btn'])) {
    $result=$sanPhamController->delete($_POST['MaSP']);
    if ($result) {
        // Handle successful deletion
        echo "<script>alert('Successfully');</script>";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        // Handle deletion failure
        echo "<script>alert('Failed ');</script>";
    }
}

// Update a product
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update-btn'])) {
    if (isset($_POST['MaSP']) && isset($_POST['TenSP']) && isset($_POST['DonViTinh']) && isset($_POST['GiaBan']) && isset($_POST['GiaNhap']) && isset($_POST['TinhTrang']) && isset($_POST['MoTa']) && isset($_POST['ThongTin']) && isset($_POST['ImageUrl']) && isset($_POST['MaLoai']) && isset($_POST['TonKho'])) {
        $data = [
            'MaSP' => $_POST['MaSP'],
            'TenSP' => $_POST['TenSP'],
            'DonViTinh' => $_POST['DonViTinh'],
            'GiaBan' => $_POST['GiaBan'],
            'GiaNhap' => $_POST['GiaNhap'],
            'TinhTrang' => $_POST['TinhTrang'],
            'MoTa' => $_POST['MoTa'],
            'ThongTin' => $_POST['ThongTin'],
            'ImageUrl' => $_POST['ImageUrl'],
            'MaLoai' => $_POST['MaLoai'],
            'TonKho' => $_POST['TonKho']
        ];
        $result=$sanPhamController->update($data);

        if ($result) {
            // Handle successful deletion
            echo "<script>alert('Successfully');</script>";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            // Handle deletion failure
            echo "<script>alert('Failed ');</script>";
        }

    } else {
        echo "Vui lòng điền đầy đủ thông tin!";
    }
}

// Search for a product
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search-product-btn'])) {
    $sanPham = $sanPhamController->searchByName($_GET['search']);
}

// Sort products
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['sort-product'])) {
    if ($_GET['sort-product'] == 'asc') {
        $sanPham = $sanPhamController->getAllAscending();
    } else {
        $sanPham = $sanPhamController->getAllDescending();
    }
}


$sql_hsx = "SELECT MaHSX, TenHSX FROM HangSanXuat";
$stmt_hsx = $db->prepare($sql_hsx);
$stmt_hsx->execute();
    // Fetch the results into an array
$hsxs = $stmt_hsx->fetchAll(PDO::FETCH_ASSOC);

?>

<!doctype html>
<html lang="en">
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <title>Quản lý Sản phẩm </title>
    <style>
        

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


.update-btn {
            display: flex;
            justify-content: flex-end;
        }

.delete-button {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background-color: rgb(20, 20, 20);
  border: none;
  font-weight: 600;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.164);
  cursor: pointer;
  transition-duration: 0.3s;
  overflow: hidden;
  position: relative;
}

.delete-svgIcon {
  width: 15px;
  transition-duration: 0.3s;
}

.delete-svgIcon path {
  fill: white;
}

.delete-button:hover {
  width: 90px;
  border-radius: 50px;
  transition-duration: 0.3s;
  background-color: rgb(255, 69, 69);
  align-items: center;
}

.delete-button:hover .delete-svgIcon {
  width: 20px;
  transition-duration: 0.3s;
  transform: translateY(60%);
  -webkit-transform: rotate(360deg);
  -moz-transform: rotate(360deg);
  -o-transform: rotate(360deg);
  -ms-transform: rotate(360deg);
  transform: rotate(360deg);
}

.delete-button::before {
  display: none;
  content: "Delete";
  color: white;
  transition-duration: 0.3s;
  font-size: 2px;
}

.delete-button:hover::before {
  display: block;
  padding-right: 10px;
  font-size: 13px;
  opacity: 1;
  transform: translateY(0px);
  transition-duration: 0.3s;
}


.update-button {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background-color: rgb(20, 20, 20);
  border: none;
  font-weight: 600;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.164);
  cursor: pointer;
  transition-duration: 0.3s;
  overflow: hidden;
  position: relative;
}

.update-svgIcon {
  width: 20px;
  transition-duration: 0.3s;
}

.update-svgIcon path {
  fill: white;
}

.update-button:hover {
  width: 90px;
  border-radius: 50px;
  transition-duration: 0.3s;
  background-color: #3399ff;
  align-items: center;
}

.update-button:hover .update-svgIcon {
  width: 20px;
  transition-duration: 0.3s;
  transform: translateY(60%);
  -webkit-transform: rotate(360deg);
  -moz-transform: rotate(360deg);
  -o-transform: rotate(360deg);
  -ms-transform: rotate(360deg);
  transform: rotate(360deg);
}

.update-button::before {
  display: none;
  content: "Update";
  color: white;
  transition-duration: 0.3s;
  font-size: 2px;
}

.update-button:hover::before {
  display: block;
  padding-right: 10px;
  font-size: 13px;
  opacity: 1;
  transform: translateY(0px);
  transition-duration: 0.3s;
}

.table th, .table td {
            text-align: center;
            vertical-align: middle;
        }

     

      
        .update-btn, .delete-button {
           
            margin-left: 10px;
            cursor: pointer;
        }
        
     

      
        .vitri{
           
            margin-left: 200px;
            text-align:center;
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

.card {
 width: 250px;
 min-height: 350px;
  padding: .8em;
 background: #f5f5f5;
 position: relative;
 overflow: visible;
 box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
}

.card-img {
 background-color: #ffcaa6;
 height: 40%;
 width: 100%;
 border-radius: .5rem;
 transition: .3s ease;
}

.card-info {
 padding-top: 10%;
}

svg {
 width: 20px;
 height: 20px;
}

.card-footer {
 width: 100%;
 display: flex;
 justify-content: space-between;
 align-items: center;
 padding-top: 10px;
 border-top: 1px solid #ddd;
}

/*Text*/
.text-title {
 font-weight: 900;
 font-size: 1.0em;
 line-height: 1.5;
}

.text-body {
 font-size: .9em;
 padding-bottom: 10px;
}

/*Button*/
.card-button {
 border: 1px solid #252525;
 display: flex;
 padding: .3em;
 cursor: pointer;
 border-radius: 50px;
 transition: .3s ease-in-out;
}

/*Hover*/
.card-img:hover {
 transform: translateY(-25%);
 box-shadow: rgba(226, 196, 63, 0.25) 0px 13px 47px -5px, rgba(180, 71, 71, 0.3) 0px 8px 16px -8px;
}

.card-button:hover {
 border: 1px solid #ffcaa6;
 background-color: #ffcaa6;
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
    <h2 >Danh sách sản phẩm</h2>
                <div class="row">
            <div class="col-6 d-flex">
                <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="d-flex">
                    <input class="form-control me-2" type="text" name="search">
                    <button name="search-product-btn" class="btn btn-outline-success" type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h.001l3.85 3.85a1 1 0 0 0 1.415-1.415l-3.85-3.85v-.001zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                        </svg>
                    </button>
                </form>
            </div>
            <div class="col-6 d-flex justify-content-end">
                <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="d-flex">
                    <button class="cta me-2" name="sort-product" value="asc">Giá tăng</button>
                    <button class="cta" name="sort-product" value="desc">Giá giảm</button>
                </form>
            </div>
        </div>



        <button class="cta" data-bs-toggle="modal" data-bs-target="#addModal">Thêm mới</button>
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Thêm sản phẩm</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="addTenSP" class="form-label">Tên sản phẩm</label>
                                <input type="text" class="form-control" id="addTenSP" name="TenSP" required>
                            </div>
                            <div class="mb-3">
                                <label for="addDonViTinh" class="form-label">Đơn vị tính</label>
                                <input type="text" class="form-control" id="addDonViTinh" name="DonViTinh" required>
                            </div>
                            <div class="mb-3">
                                <label for="addGiaBan" class="form-label">Giá bán</label>
                                <input type="number" class="form-control" id="addGiaBan" min="1" name="GiaBan" required>
                            </div>
                            <div class="mb-3">
                                <label for="addGiaNhap" class="form-label">Giá nhập</label>
                                <input type="number" class="form-control" id="addGiaNhap" min="1" name="GiaNhap" required>
                            </div>
                            <div class="mb-3">
                                <label for="addTinhTrang" class="form-label">Tình trạng</label>
                                <select class="form-control" id="addTinhTrang" name="TinhTrang" required>
                                              
                                              <option value="Còn hàng">Còn hàng</option>';
                                              <option value="Hết hàng">Hết hàng</option>';
                                              
                                         
                                      </select>                                      </div>
                            <div class="mb-3">
                                <label for="addMoTa" class="form-label">Mô tả</label>
                                <textarea class="form-control" id="addMoTa" name="MoTa" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="addThongTin" class="form-label">Thông tin</label>
                                <textarea class="form-control" id="addThongTin" name="ThongTin" required></textarea>
                            </div>
                            <div class="mb-3">
                              <label for="addImageUrl" class="form-label">Chọn hình ảnh</label>
                              <input type="file" class="form-control" id="addImageUrl" name="image" accept="image/*" required>
                          </div>

                            <div class="mb-3">
                                <label for="addMaLoai" class="form-label">Loại sản phẩm</label>
                                <select class="form-control" id="addMaLoai" name="MaLoai" required>
                                              
                                                      <option value="1">Vật liệu</option>';
                                                      <option value="2">Loa nhà yến</option>';
                                                      <option value="3">Máy tạo ẩm</option>';
                                                      <option value="4">Thiết bị điện</option>';
                                                      <option value="5">Dung dịch tạo mùi</option>';
                                                      <option value="6">Amply nhà yến</option>';
                                                      <option value="7">Máy phun béc</option>';
                                                 
                                              </select>                          
                                  </div>
                            <div class="mb-3">
                                <label for="addTonKho" class="form-label">Tồn kho</label>
                                <input type="number" class="form-control" id="addTonKho" name="TonKho" min="0" required>
                            </div>

                            <div class="mb-3">
            <label for="addHSX" class="form-label">Hãng sản xuất</label>
            <select class="form-control" id="addHSX" name="MaHSX" required>
                                              
            <?php
                // Assuming you have an array of categories called $categories
                foreach ($hsxs as $hsx) {
                    echo '<option value="' . $hsx['MaHSX'] . '">' . $hsx['TenHSX'] . '</option>';
                }
                ?>
                                         
                                      </select>          </div>

                            <button type="submit" name="add-product-btn" class="btn btn-primary">Thêm mới</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="row">
            <?php foreach ($sanPham as $sp) : ?>
                <div class="col-md-3">
                    <div class="card">
                        <img class="card-img" src="../image/sanpham/<?php echo $sp['ImageUrl']; ?>" class="card-img-top" alt="<?php echo $sp['TenSP']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $sp['TenSP']; ?></h5>
                            <p class="card-text"><strong>Mã loại:</strong> <?php echo $sp['MaLoai']; ?></p>
                            <p class="card-text"><strong>Giá bán:</strong> <?php echo $sp['GiaBan']; ?> VND</p>
                            <div class="d-flex justify-content-between">
                            <button class="update-button update-btn" type="button" data-bs-toggle="modal" data-bs-target="#updateModal-<?php echo $product['MaSP']; ?>"
                            data-masp="<?php echo $sp['MaSP']; ?>"

                            data-tensp="<?php echo $sp['TenSP']; ?>"
                            data-donvitinh="<?php echo $sp['DonViTinh']; ?>"
                            data-giaban="<?php echo $sp['GiaBan']; ?>"
                            data-gianhap="<?php echo $sp['GiaNhap']; ?>"
                            data-tinhtrang="<?php echo $sp['TinhTrang']; ?>"
                            data-mota="<?php echo $sp['MoTa']; ?>"
                            data-thongtin="<?php echo $sp['ThongTin']; ?>"
                            data-imageurl="<?php echo $sp['ImageUrl']; ?>"
                            data-maloai="<?php echo $sp['MaLoai']; ?>"
                            data-tonkho="<?php echo $sp['TonKho']; ?>">
                            
                            <svg class="bi bi-pencil-square update-svgIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 512 512">
                                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM135.1 217.4l107.1-99.9c3.8-3.5 8.7-5.5 13.8-5.5s10.1 2 13.8 5.5l107.1 99.9c4.5 4.2 7.1 10.1 7.1 16.3c0 12.3-10 22.3-22.3 22.3H304v96c0 17.7-14.3 32-32 32H240c-17.7 0-32-14.3-32-32V256H150.3C138 256 128 246 128 233.7c0-6.2 2.6-12.1 7.1-16.3z"/>
                            </svg>
                        </button>

                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="d-inline" onsubmit="return confirmDelete();">
                            <input type="hidden" name="MaSP" value="<?php echo $sp['MaSP']; ?>">
                            <button type="submit" name="delete-product-btn" class="delete-button">
                                <svg class="delete-svgIcon" viewBox="0 0 448 512">
                                    <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                    </div>

                    
                <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateModalLabel">Cập Nhật Sản phẩm</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
          <input type="hidden" name="MaSP" id="updateMaSP">
                    <div class="mb-3">
                        <label for="updateMaSPModal" class="form-label">Mã sản phẩm</label>
                        <input type="number" class="form-control" id="updateMaSPModal" name="MaSP" readonly>
                    </div>

          <div class="mb-3">
            <label for="updateTenSP" class="form-label">Tên Sản phẩm</label>
            <input type="text" class="form-control" id="updateTenSP" name="TenSP" required>
          </div>
          <div class="mb-3">
            <label for="updateDonViTinh" class="form-label">Đơn vị tính</label>
            <input type="text" class="form-control" id="updateDonViTinh" name="DonViTinh" required>
          </div>
          <div class="mb-3">
            <label for="updateGiaBan" class="form-label">Giá bán</label>
            <input type="number" class="form-control" id="updateGiaBan" min="1" name="GiaBan" required>
          </div>
          <div class="mb-3">
            <label for="updateGiaNhap" class="form-label">Giá nhập</label>
            <input type="number" class="form-control" id="updateGiaNhap" name="GiaNhap" min="1" required>
          </div>
          <div class="mb-3">
            <label for="updateTinhTrang" class="form-label">Tình trạng</label>
            <select class="form-control" id="updateTinhTrang" name="TinhTrang" required>
                                              
                                              <option value="Còn hàng">Còn hàng</option>';
                                              <option value="Hết hàng">Hết hàng</option>';
                                              
                                         
                                      </select>  
          </div>
          <div class="mb-3">
            <label for="updateMoTa" class="form-label">Mô tả</label>
            <textarea class="form-control" id="updateMoTa" name="MoTa" required></textarea>
          </div>
          <div class="mb-3">
            <label for="updateThongTin" class="form-label">Thông tin</label>
            <textarea class="form-control" id="updateThongTin" name="ThongTin" required></textarea>
          </div>
          <div class="mb-3">
            <label for="updateImageUrl" class="form-label">URL hình ảnh</label>
            <input type="text" class="form-control" id="updateImageUrl" name="ImageUrl"readonly required>
          </div>
          <div class="mb-3">
            <label for="updateMaLoai" class="form-label">Mã loại</label>
            <select class="form-control" id="updateMaLoai" name="MaLoai" required>
                                              
                                              <option value="1">Vật liệu</option>';
                                              <option value="2">Loa nhà yến</option>';
                                              <option value="3">Máy tạo ẩm</option>';
                                              <option value="4">Thiết bị điện</option>';
                                              <option value="5">Dung dịch tạo mùi</option>';
                                              <option value="6">Amply nhà yến</option>';
                                              <option value="7">Máy phun béc</option>';
                                         
                                      </select>          </div>
          <div class="mb-3">
            <label for="updateTonKho" class="form-label">Tồn kho</label>
            <input type="number" class="form-control" id="updateTonKho" name="TonKho" min="0" required>
          </div>

          

          <button type="submit" class="btn btn-primary" name="update-btn">Cập nhật</button>
        </form>
      </div>
    </div>
  </div>
</div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div></div>
    </div>


      <div class="row">
        <div id="footer">
        </div>
      </div>
    </div>

    <script>

document.querySelectorAll('.update-btn').forEach(button => {
  button.addEventListener('click', event => {
    const id = button.getAttribute('data-masp');

    const TenSP = button.getAttribute('data-tensp');
    const DonViTinh = button.getAttribute('data-donvitinh');
    const GiaBan = button.getAttribute('data-giaban');
    const GiaNhap = button.getAttribute('data-gianhap');
    const TinhTrang = button.getAttribute('data-tinhtrang');
    const MoTa = button.getAttribute('data-mota');
    const ThongTin = button.getAttribute('data-thongtin');
    const ImageUrl = button.getAttribute('data-imageurl');
    const MaLoai = button.getAttribute('data-maloai');
    const TonKho = button.getAttribute('data-tonkho');

    document.getElementById('updateMaSPModal').value = id;

    document.getElementById('updateTenSP').value = TenSP;
    document.getElementById('updateDonViTinh').value = DonViTinh;
    document.getElementById('updateGiaBan').value = GiaBan;
    document.getElementById('updateGiaNhap').value = GiaNhap;
    document.getElementById('updateTinhTrang').value = TinhTrang;
    document.getElementById('updateMoTa').value = MoTa;
    document.getElementById('updateThongTin').value = ThongTin;
    document.getElementById('updateImageUrl').value = ImageUrl;
    document.getElementById('updateMaLoai').value = MaLoai;
    document.getElementById('updateTonKho').value = TonKho;

    var myModal = new bootstrap.Modal(document.getElementById('updateModal'));
    myModal.show();
  });
});


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

      function confirmDelete() {
        return confirm("Bạn có chắc muốn xóa tài khoản này không?");
    }

 // Lắng nghe sự kiện click trên các nút "Xóa"
 document.addEventListener('click', function(event) {
            // Kiểm tra xem sự kiện click đến từ nút "Xóa" và form "Sửa" không được mở
            if (event.target.classList.contains('delete-btn') && !isUpdateFormOpen) {
                event.preventDefault();
                console.log('Delete button clicked');
                const confirmed = confirm('Bạn có chắc muốn xóa tin tức này không?');
                if (confirmed) {
                    console.log('Confirmed deletion');
                    const form = event.target.closest('form');
                    console.log('Form will be submitted', form);
                    form.submit();
                }
            }
        });
 


    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
  </body>
</html>
