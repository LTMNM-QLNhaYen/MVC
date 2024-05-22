<?php
// Include tệp kết nối cơ sở dữ liệu và mô hình
include_once '../model/DB.php';
include_once '../model/HangSanXuat.php'; // Thay đổi đường dẫn đến mô hình HangSanXuat.php
include_once '../controller/HangSanXuat_con.php'; // Thay đổi đường dẫn đến controller HangSanXuat_con.php

$db = new DB();
$hangSanXuatController = new HangSanXuatController($db); // Thay đổi tên biến và class
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
// Thêm hãng sản xuất mới
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add-btn'])) {
   
    $data = [
        'TenHSX' => $_POST['TenHSX'],
        'DiaChi' => $_POST['DiaChi'],
        'SDT' => $_POST['SDT']
    ];
    $result=$hangSanXuatController->create($data);

    if ($result) {
        // Handle successful update
        echo "<script>alert('Employee updated successfully');</script>";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        // Handle update failure
        echo "<script>alert('Failed to update employee');</script>";
    }
}

// Lấy tất cả hãng sản xuất
$hangSanXuat = $hangSanXuatController->read(); // Thay đổi tên biến

// Xóa hãng sản xuất
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete-btn'])) {
    $result=$hangSanXuatController->delete($_POST['MaHSX']);


    
    if ($result) {
        // Handle successful update
        echo "<script>alert('Employee updated successfully');</script>";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        // Handle update failure
        echo "<script>alert('Failed to update employee');</script>";
    }
}

// Sửa hãng sản xuất
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update-btn'])) {
   
    $data = [
        'MaHSX' => $_POST['MaHSX'],
        'TenHSX' => $_POST['TenHSX'],
        'DiaChi' => $_POST['DiaChi'],
        'SDT' => $_POST['SDT']
    ];
    $result=$hangSanXuatController->update($data);

    
    if ($result) {
        // Handle successful update
        echo "<script>alert('Employee updated successfully');</script>";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        // Handle update failure
        echo "<script>alert('Failed to update employee');</script>";
    }
}

// Tìm kiếm tin tức
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search-btn'])) {
    $hangSanXuat = $hangSanXuatController->searchByTenHSX($_GET['search']);
}

// Sắp xếp tin tức
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['sort'])) {
    if ($_GET['sort'] == 'asc') {
        $hangSanXuat = $hangSanXuatController->getAllAscending();
    } else {
        $hangSanXuat = $hangSanXuatController->getAllDescending();
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
    <title>Quản lý thông tin hãng sản xuất</title>
    <link rel="stylesheet" type="text/css" href="style.css">
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
<h1>Quản lý hãng sản xuất</h1>
    
   

    <button class="cta" data-bs-toggle="modal" data-bs-target="#addModal"  >
                Thêm mới
    </button>

    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="addModalLabel">Thêm Hãng sản xuất</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="mb-3">
            <label for="addTenHSX" class="form-label">Tên Hãng sản xuất</label>
            <input type="text" class="form-control" id="addTenHSX" name="TenHSX">
        </div>
        <div class="mb-3">
            <label for="addDiaChi" class="form-label">Địa chỉ</label>
            <input type="text" class="form-control" id="addDiaChi" name="DiaChi">
        </div>
        <div class="mb-3">
            <label for="addSDT" class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" id="addSDT" name="SDT">
        </div>
          <button type="submit" class="btn btn-primary vitri"  name="add-btn">Thêm</button>
        </form>
      </div>
    </div> </div> </div> 


    <div class="row">
<div class="col-6">
    <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        
        <label> <input  class="form-control me-2" type="text" name="search"></label>
        <button name="search-btn"  class="btn btn-outline-success" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                            </svg>
        </button>
    </form>
</div>
<div class="col-6">
<form  method="get" action="">
    <button type="action"  class="btn btn-sm btn-outline-secondary" name="sort" value="asc">Sắp xếp tăng dần</button> | <button    class="btn btn-sm btn-outline-secondary" name="sort" type="action"  value="des" >Sắp xếp giảm dần</button>
</form>


</div>

</div>



        <table class="table" style="width: 100%;" border="1">
        <tr style="text-align: center;">
            <th scope="col">Mã hãng sản xuất</th>
            <th scope="col">Tên hãng sản xuất</th>
            <th scope="col">Địa chỉ</th>
            <th scope="col">Số điện thoại</th>
            <th scope="col">Thao tác</th>
        </tr>
        <tbody style="line-height: 40px; height: 40px;">
            <?php foreach ($hangSanXuat as $index => $hsx): ?>
                <tr>
                    <td style="text-align: center;"><?php echo $hsx['MaHSX']; ?></td>
                    <td><?php echo $hsx['TenHSX']; ?></td>
                    <td><?php echo $hsx['DiaChi']; ?></td>
                    <td><?php echo $hsx['SDT']; ?></td>
                    <td style=" width:100%;  
                        display: flex;
                        justify-content: flex-end;
                        align-items: center;" > 
                        <button class="update-button update-btn" data-bs-toggle="modal" data-bs-target="#updateModal" 
                            data-id="<?php echo $hsx['MaHSX']; ?>" 
                            data-tenhsx="<?php echo $hsx['TenHSX']; ?>" 
                            data-diachi="<?php echo $hsx['DiaChi']; ?>" 
                            data-sdt="<?php echo isset($hsx['SDT']) ? $hsx['SDT'] : ''; ?>"
                        >
                        <svg class="bi bi-pencil-square update-svgIcon" xmlns="http://www.w3.org/2000/svg"  width="20" height="20" viewBox="0 0 512 512" >
                                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM135.1 217.4l107.1-99.9c3.8-3.5 8.7-5.5 13.8-5.5s10.1 2 13.8 5.5l107.1 99.9c4.5 4.2 7.1 10.1 7.1 16.3c0 12.3-10 22.3-22.3 22.3H304v96c0 17.7-14.3 32-32 32H240c-17.7 0-32-14.3-32-32V256H150.3C138 256 128 246 128 233.7c0-6.2 2.6-12.1 7.1-16.3z"/></svg>

                        </button>
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return confirmDelete();">
                            <input type="hidden" name="MaHSX" value="<?php echo $hsx['MaHSX']; ?>">
                            <button class="delete-button" type="submit" name="delete-btn"   >
                            <svg class="delete-svgIcon" viewBox="0 0 448 512">
                                                <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"></path>
                            </svg>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="updateModalLabel">Cập Nhật Thông Tin Hãng Sản Xuất</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="MaHSX" id="updateMaHSX">
        <div class="mb-3">
            <label for="updateMaHSXModal" class="form-label">Mã hãng sản xuất</label>
            <input type="number" class="form-control" id="updateMaHSXModal" name="MaHSX" readonly>
        </div>
        <div class="mb-3">
            <label for="updateTenHSX" class="form-label">Tên hãng sản xuất</label>
            <input type="text" class="form-control" id="updateTenHSX" name="TenHSX">
        </div>
        <div class="mb-3">
            <label for="updateDiaChi" class="form-label">Địa chỉ</label>
            <input type="text" class="form-control" id="updateDiaChi" name="DiaChi">
        </div>
        <div class="mb-3">
            <label for="updateSDT" class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" id="updateSDT" name="SDT">
        </div>
          <button type="submit" class="btn btn-primary" name="update-btn">Cập Nhật</button>
        </form>
      </div>
    </div>
   

          
        </div>
      </div></div>
      </div></div>
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
    <script>
   document.addEventListener('DOMContentLoaded', function() {
        const updateButtons = document.querySelectorAll('.update-btn');
        updateButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.stopPropagation();
                const id = this.getAttribute('data-id');
                const tenHSX = this.getAttribute('data-tenHSX');
                const diaChi = this.getAttribute('data-diaChi');
                const sdt = this.getAttribute('data-sdt');
                
                // Truyền giá trị mã nhà sản xuất vào input tương ứng trong modal
                document.getElementById('updateMaHSXModal').value = id;
                document.getElementById('updateTenHSX').value = tenHSX;
                document.getElementById('updateDiaChi').value = diaChi;
                document.getElementById('updateSDT').value = sdt;
               
                // Mở modal
                var myModal = new bootstrap.Modal(document.getElementById('updateModal'));
                myModal.show();
            });
        });
    });
    function confirmDelete() {
        return confirm("Bạn có chắc muốn xóa tài khoản này không?");
    }

  
    document.getElementById('updateModal').addEventListener('hidden.bs.modal', function (event) {
      isUpdateFormOpen = false; // Đặt biến cờ khi form "Sửa" được đóng
    });


        // Lắng nghe sự kiện click trên các nút "Xóa"
        document.addEventListener('click', function(event) {
            // Kiểm tra xem sự kiện click đến từ nút "Xóa" và form "Sửa" không được mở
            if (event.target.classList.contains('delete-btn') && !isUpdateFormOpen) {
                event.preventDefault();
                console.log('Delete button clicked');
                const confirmed = confirm('Bạn có chắc muốn xóa hãng sản xuât  này không?');
                if (confirmed) {
                    console.log('Confirmed deletion');
                    const form = event.target.closest('form');
                    console.log('Form will be submitted', form);
                    form.submit();
                }
            }
        });
 
</script>

  </body>
</html>
