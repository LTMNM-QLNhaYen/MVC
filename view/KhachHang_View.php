<?php
// Include tệp kết nối cơ sở dữ liệu và mô hình
include_once '../model/DB.php';
include_once '../model/KhachHang.php'; // Thay đổi đường dẫn đến mô hình KhachHang.php
include_once '../controller/KhachHang_con.php'; // Thay đổi đường dẫn đến controller KhachHangController.php

$db = new DB();
$khachHangController = new KhachHangController($db); // Thay đổi tên biến và class

// Thêm khách hàng mới
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add-btn'])) {
    $data = [
        'TenKH' => $_POST['TenKH'],
        'Phai' => $_POST['Phai'],
        'NgaySinh' => $_POST['NgaySinh'],
        'DiaChi' => $_POST['DiaChi'],
        'SDT' => $_POST['SDT'],
        'UserName' => $_POST['UserName'],
        'MatKhau' => $_POST['MatKhau'],
        'Email' => $_POST['Email'],
        'TrangThai' => $_POST['TrangThai']
    ];
    $result = $khachHangController->create($data);

    if ($result) {
        // Handle successful addition
        echo "<script>alert('Khách hàng thêm thành công');</script>";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        // Handle addition failure
        echo "<script>alert('Thêm khách hàng thất bại');</script>";
    }
}

// Lấy tất cả khách hàng
$khachHang = $khachHangController->read();

// Xóa khách hàng
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete-btn'])) {
    $result = $khachHangController->delete($_POST['MaKH']);

    if ($result) {
        // Handle successful deletion
        echo "<script>alert('Khách hàng xóa thành công');</script>";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        // Handle deletion failure
        echo "<script>alert('Xóa khách hàng thất bại');</script>";
    }
}

// Sửa khách hàng
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update-btn'])) {
    $data = [
        'MaKH' => $_POST['MaKH'],
        'TenKH' => $_POST['TenKH'],
        'Phai' => $_POST['Phai'],
        'NgaySinh' => $_POST['NgaySinh'],
        'DiaChi' => $_POST['DiaChi'],
        'SDT' => $_POST['SDT'],
        'UserName' => $_POST['UserName'],
        'MatKhau' => $_POST['MatKhau'],
        'Email' => $_POST['Email'],
        'TrangThai' => $_POST['TrangThai']
    ];
    $result = $khachHangController->update($data);

    if ($result) {
        // Handle successful update
        echo "<script>alert('Khách hàng cập nhật thành công');</script>";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        // Handle update failure
        echo "<script>alert('Cập nhật khách hàng thất bại');</script>";
    }
}

// Tìm kiếm khách hàng
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search-btn'])) {
    $khachHang = $khachHangController->searchByName($_GET['search']);
}

// Sắp xếp khách hàng
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['sort'])) {
    if ($_GET['sort'] == 'asc') {
        $khachHang = $khachHangController->getAllAscending();
    } else {
        $khachHang = $khachHangController->getAllDescending();
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


        <h1>Quản lý khách hàng</h1>

<button class="cta" data-bs-toggle="modal" data-bs-target="#addModal">
    Thêm mới
</button>

<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Thêm Khách hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="mb-3">
                        <label for="addTenKH" class="form-label">Tên Khách hàng</label>
                        <input type="text" class="form-control" id="addTenKH" name="TenKH">
                    </div>
                    <div class="mb-3">
                        <label for="addPhai" class="form-label">Phái</label>
                        <select class="form-select" id="addPhai" name="Phai">
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="addNgaySinh" class="form-label">Ngày Sinh</label>
                        <input type="date" class="form-control" id="addNgaySinh" name="NgaySinh">
                    </div>
                    <div class="mb-3">
                        <label for="addDiaChi" class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" id="addDiaChi" name="DiaChi">
                    </div>
                    <div class="mb-3">
                        <label for="addSDT" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="addSDT" name="SDT">
                    </div>
                    <div class="mb-3">
                        <label for="addUserName" class="form-label">UserName</label>
                        <input type="text" class="form-control" id="addUserName" name="UserName">
                    </div>
                    <div class="mb-3">
                        <label for="addMatKhau" class="form-label">Mật Khẩu</label>
                        <input type="password" class="form-control" id="addMatKhau" name="MatKhau">
                    </div>
                    <div class="mb-3">
                        <label for="addEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="addEmail" name="Email">
                    </div>
                    <div class="mb-3">
                        <label for="addTrangThai" class="form-label">Trạng Thái</label>
                        <input type="text" class="form-control" id="addTrangThai" name="TrangThai" value="Không khoá">
                    </div>
                    <button type="submit" class="btn btn-primary vitri" name="add-btn">Thêm</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-6">
        <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label><input class="form-control me-2" type="text" name="search"></label>
            <button name="search-btn" class="btn btn-outline-success" type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                </svg>
            </button>
        </form>
    </div>
    <div class="col-6">
        <form method="get" action="">
            <button type="action" class="btn btn-sm btn-outline-secondary" name="sort" value="asc">Sắp xếp tăng dần</button> | 
            <button class="btn btn-sm btn-outline-secondary" name="sort" type="action" value="des">Sắp xếp giảm dần</button>
        </form>
    </div>
</div>

<table class="table" style="width: 100%;" border="1">
    <tr style="text-align: center;">
        <th scope="col">Mã khách hàng</th>
        <th scope="col">Tên khách hàng</th>
        <th scope="col">Phái</th>
        <th scope="col">Ngày Sinh</th>
        <th scope="col">Địa chỉ</th>
        <th scope="col">Số điện thoại</th>
        <th scope="col">UserName</th>
        <th scope="col">Email</th>
        <th scope="col">Trạng Thái</th>
        <th scope="col">Thao tác</th>
    </tr>
    <tbody style="line-height: 40px; height: 40px;">
        <?php foreach ($khachHang as $index => $kh): ?>
            <tr>
                <td style="text-align: center;"><?php echo $kh['MaKH']; ?></td>
                <td><?php echo $kh['TenKH']; ?></td>
                <td><?php echo $kh['Phai']; ?></td>
                <td><?php echo $kh['NgaySinh']; ?></td>
                <td><?php echo $kh['DiaChi']; ?></td>
                <td><?php echo $kh['SDT']; ?></td>
                <td><?php echo $kh['UserName']; ?></td>
                <td><?php echo $kh['Email']; ?></td>
                <td><?php echo $kh['TrangThai']; ?></td>
                <td style="width: 100%; display: flex; justify-content: flex-end; align-items: center;">
                    <button class="update-button update-btn" data-bs-toggle="modal" data-bs-target="#updateModal" 
                        data-id="<?php echo $kh['MaKH']; ?>" 
                        data-tenkh="<?php echo $kh['TenKH']; ?>" 
                        data-phai="<?php echo $kh['Phai']; ?>" 
                        data-ngaysinh="<?php echo $kh['NgaySinh']; ?>" 
                        data-diachi="<?php echo $kh['DiaChi']; ?>" 
                        data-sdt="<?php echo $kh['SDT']; ?>" 
                        data-username="<?php echo $kh['UserName']; ?>" 
                        data-email="<?php echo $kh['Email']; ?>" 
                        data-trangthai="<?php echo $kh['TrangThai']; ?>"
                    >
                        <svg class="bi bi-pencil-square update-svgIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 512 512">
                            <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM135.1 217.4l107.1-99.9c3.8-3.5 8.7-5.5 13.8-5.5s10.1 2 13.8 5.5l107.1 99.9c4.5 4.2 7.1 10.1 7.1 16.3c0 12.3-10 22.3-22.3 22.3H304v96c0 17.7-14.3 32-32 32H240c-17.7 0-32-14.3-32-32V256H150.3C138 256 128 246 128 233.7c0-6.2 2.6-12.1 7.1-16.3z"/>
                        </svg>
                    </button>
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return confirmDelete();">
                        <input type="hidden" name="MaKH" value="<?php echo $kh['MaKH']; ?>">
                        <button class="delete-button" type="submit" name="delete-btn">
                            <svg class="delete-svgIcon" viewBox="0 0 448 512">
                                <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/>
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
                <h5 class="modal-title" id="updateModalLabel">Cập Nhật Thông Tin Khách Hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="MaKH" id="updateMaKH">
                    <div class="mb-3">
                        <label for="updateMaKHModal" class="form-label">Mã khách hàng</label>
                        <input type="number" class="form-control" id="updateMaKHModal" name="MaKH" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="updateTenKH" class="form-label">Tên khách hàng</label>
                        <input type="text" class="form-control" id="updateTenKH" name="TenKH">
                    </div>
                    <div class="mb-3">
                        <label for="updatePhai" class="form-label">Phái</label>
                        <select class="form-select" id="updatePhai" name="Phai">
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="updateNgaySinh" class="form-label">Ngày Sinh</label>
                        <input type="date" class="form-control" id="updateNgaySinh" name="NgaySinh">
                    </div>
                    <div class="mb-3">
                        <label for="updateDiaChi" class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" id="updateDiaChi" name="DiaChi">
                    </div>
                    <div class="mb-3">
                        <label for="updateSDT" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="updateSDT" name="SDT">
                    </div>
                    <div class="mb-3">
                        <label for="updateUserName" class="form-label">UserName</label>
                        <input type="text" class="form-control" id="updateUserName" name="UserName">
                    </div>
                    <div class="mb-3">
                        <label for="updateMatKhau" class="form-label">Mật Khẩu</label>
                        <input type="password" class="form-control" id="updateMatKhau" name="MatKhau">
                    </div>
                    <div class="mb-3">
                        <label for="updateEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="updateEmail" name="Email">
                    </div>
                    <div class="mb-3">
                        <label for="updateTrangThai" class="form-label">Trạng Thái</label>
                        <input type="text" class="form-control" id="updateTrangThai" name="TrangThai">
                    </div>
                    <button type="submit" class="btn btn-primary" name="update-btn">Cập Nhật</button>
                </form>
            </div>
        </div>
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

      document.addEventListener('DOMContentLoaded', function() {
            let isUpdateFormOpen = false; // Biến cờ để kiểm tra trạng thái form "Sửa" 

            const updateButtons = document.querySelectorAll('.update-btn');
            updateButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.stopPropagation();
                    const id = this.getAttribute('data-id');
                    const tenKH = this.getAttribute('data-tenkh');
                    const phai = this.getAttribute('data-phai');
                    const ngaySinh = this.getAttribute('data-ngaysinh');
                    const diaChi = this.getAttribute('data-diachi');
                    const sdt = this.getAttribute('data-sdt');
                    const userName = this.getAttribute('data-username');
                    const email = this.getAttribute('data-email');
                    const trangThai = this.getAttribute('data-trangthai');
                    
                    // Truyền giá trị khách hàng vào input tương ứng trong modal
                    document.getElementById('updateMaKHModal').value = id;
                    document.getElementById('updateTenKH').value = tenKH;
                    document.getElementById('updatePhai').value = phai;
                    document.getElementById('updateNgaySinh').value = ngaySinh;
                    document.getElementById('updateDiaChi').value = diaChi;
                    document.getElementById('updateSDT').value = sdt;
                    document.getElementById('updateUserName').value = userName;
                    document.getElementById('updateMatKhau').value = '';
                    document.getElementById('updateEmail').value = email;
                    document.getElementById('updateTrangThai').value = trangThai;
                   
                    // Mở modal
                    var myModal = new bootstrap.Modal(document.getElementById('updateModal'));
                    myModal.show();
                    isUpdateFormOpen = true; // Đặt biến cờ khi form "Sửa" được mở
                });
            });

            document.getElementById('updateModal').addEventListener('hidden.bs.modal', function (event) {
                isUpdateFormOpen = false; // Đặt biến cờ khi form "Sửa" được đóng
            });

            function confirmDelete() {
    return confirm("Bạn có chắc muốn xóa khách hàng này không?");
}

                // Lắng nghe sự kiện click trên các nút "Xóa"
            document.addEventListener('click', function(event) {
                // Kiểm tra xem sự kiện click đến từ nút "Xóa" và form "Sửa" không được mở
                if (event.target.classList.contains('delete-button') && !isUpdateFormOpen) {
                    event.preventDefault();
                    const confirmed = confirm('Bạn có chắc muốn xóa khách hàng này không?');
                    if (confirmed) {
                        const form = event.target.closest('form');
                        form.submit();
                    }
                }
            });
        });


    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
  </body>
</html>
