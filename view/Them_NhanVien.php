<?php 
require_once '../model/DB.php';
require_once '../model/NhanVien.php';
require_once '../controller/NhanVien_con.php';

$db = new DB();
$controller = new NhanVienController($db);
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

if(isset($_POST['btn_them'])) {
    $ten = $_POST['ten'];
    $sdt = $_POST['sdt'];
    $dc = $_POST['dc'];
    $gt = $_POST['gt'];
    $ns = $_POST['ns'];

    // Create an associative array with data
    $data = array(
        'TenNV' => $ten,
        'Phai' => $gt,
        'NgaySinh' => $ns,
        'DiaChi' => $dc,
        'SDT' => $sdt
    );

    // Call the controller's create method to add employee
    $result = $controller->create($data);

    // Check the result and display appropriate message
    if ($result) {
        echo '<script>var toastEl = document.getElementById("thanhcong");
        var toast = new bootstrap.Toast(toastEl);
        toast.show();</script>';
    } else {
        echo '<script>var toastEl = document.getElementById("thatbai");
        var toast = new bootstrap.Toast(toastEl);
        toast.show();</script>';
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý thông tin nhân viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
        <div class="row shadow-lg p-3 mb-5 bg-body-tertiary rounded">
            <div class="col-2">
                <div id="sidebar"></div>
            </div>
        
            <div class="col-8" style="padding: 20px 20px 20px 10px;">

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

                <h4>Thêm thông tin nhân viên</h4>

                <form class="row g-3" method="POST" action="Them_NhanVien.php" enctype="multipart/form-data" name="add_NV">
                    <div class="col-12">
                        <label for="ten" class="form-label">Họ và tên</label>
                        <input type="text" class="form-control" id="ten" name="ten">
                    </div>
                    <div class="col-12">
                        <label for="sdt" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="sdt" name="sdt"pattern="[0-9]{10}" required title="Số điện thoại phải có 10 chữ số">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="gt" class="form-label">Giới tính</label>
                        <select id="gt" class="form-select" name="gt">
                            <option selected>Chọn...</option>
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="ns" class="form-label">Ngày sinh</label>
                        <input type="date" class="form-control" id="ns" name="ns">
                    </div>
                    <div class="col-12">
                        <label for="dc" class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" id="dc" name="dc">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary" id="btn_them" name="btn_them">Thêm nhân viên</button>
                        <button class="btn btn-secondary" type="submit" disabled >Hủy</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="thanhcong" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <svg xmlns="http://www.w3.org/2000/svg" style="color: green" width="16" height="16" fill="currentColor" class="bi bi-check-square-fill" viewBox="0 0 16 16">
                        <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm10.03 4.97a.75.75 0 0 1 .011 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.75.75 0 0 1 1.08-.022z"/>
                    </svg>
                    <strong class="me-auto">&nbsp;&nbsp;Thông Báo</strong>
                    <small>Now</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    Thêm thông tin thành công!
                </div>
            </div>
        </div>

        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="thatbai" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                    <svg xmlns="http://www.w3.org/2000/svg" style="color: red" width="16" height="16" fill="currentColor" class="bi bi-x-square-fill" viewBox="0 0 16 16">
                        <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm3.354 4.646L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 1 1 .708-.708"/>
                    </svg>
                    <strong class="me-auto">&nbsp;&nbsp;Thông Báo</strong>
                    <small>Now</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    Thêm thông tin thất bại!
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
