<?php
// Include tệp kết nối cơ sở dữ liệu và mô hình
include_once '../model/DB.php';
include_once '../model/HoaDon.php'; // Thay đổi đường dẫn đến mô hình KhachHang.php
include_once '../controller/HoaDon_con.php'; // Thay đổi đường dẫn đến controller KhachHangController.php

$db = new DB();
$hoaDonController = new HoaDonController($db); // Thay đổi tên biến và class



$hoaDon = $hoaDonController->read();


// Sửa hoá đơn
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update-btn'])) {
  $data = [
      'MaKH' => $_POST['MaKH'],
      'NgayLapHD' => $_POST['NgayLapHD'],
      'SoHoaDon' => $_POST['SoHoaDon'],
      'TenNguoiNhan' => $_POST['TenNguoiNhan'],
      'DiaChi' => $_POST['DiaChi'],
      'SDT' => $_POST['SDT'],
      'Email' => $_POST['Email'],
      'ThanhTien' => $_POST['ThanhTien'],
      'GhiChu' => $_POST['GhiChu'],
      'TrangThai' => $_POST['TrangThai'],
      'TrangThaiDonHang' => $_POST['TrangThaiDonHang']
  ];

  $result = $hoaDonController->update($data);

  if ($result) {
      // Xử lý cập nhật thành công
      echo "<script>alert('Hoá đơn cập nhật thành công');</script>";
      header("Location: " . $_SERVER['PHP_SELF']);
      exit();
  } else {
      // Xử lý cập nhật thất bại
      echo "<script>alert('Cập nhật hoá đơn thất bại');</script>";
  }
}


// Tìm kiếm khách hàng
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search-btn'])) {
    $hoaDon = $hoaDonController->searchByTenNguoiNhan($_GET['search']);
}

// Sắp xếp khách hàng
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['sort'])) {
    if ($_GET['sort'] == 'asc') {
        $hoaDon = $hoaDonController->getAllAscendingByDate();
    } else {
        $hoaDon = $hoaDonController->getAllDescendingByDate();
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['xuat'])) {
  if ($_GET['xuat'] == '1') {
    $hoaDon = $hoaDonController->getByTrangThaiDonHang('Đã xác nhận');

  } elseif ($_GET['xuat'] == '2') { 
    $hoaDon = $hoaDonController->getByTrangThaiDonHang('Đang giao hàng');
  } elseif ($_GET['xuat'] == '3') { 
    $hoaDon = $hoaDonController->getByTrangThaiDonHang('Giao hàng thành công');
  } elseif ($_GET['xuat'] == '4') { 
    $hoaDon = $hoaDonController->getByTrangThaiDonHang('Giao hàng thất bại');
  } else { 
    $hoaDon = $hoaDonController->getByTrangThaiDonHang('Đã huỷ');
  }
}
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['xn'])) {
  if ($_GET['xn'] == '8') {
      $hoaDon = $hoaDonController->getByTrangThai(1);
  } else {
      $hoaDon = $hoaDonController->getByTrangThai(0);
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
    <title>Quản lý Đơn hàng</title>
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


.button2 {
  width: 40px;
  height: 40px;
  border: 3px solid #315cfd;
  border-radius: 45px;
  transition: all 0.3s;
  cursor: pointer;
  background: white;
  font-size: 1.2em;
  font-weight: 550;
  font-family: 'Montserrat', sans-serif;
}

.button2:hover {
  background: #315cfd;
  color: white;
  font-size: 1.5em;
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
            <button class="btn btn-sm btn-outline-secondary" name="sort" type="action" value="des">Sắp xếp giảm dần</button> | 
            <button class="btn btn-sm btn-outline-secondary" name="xuat" type="action" value="1">Đã xác nhận</button> | 
            <button class="btn btn-sm btn-outline-secondary" name="xuat" type="action" value="2">Đang giao hàng</button> | 
            <button class="btn btn-sm btn-outline-secondary" name="xuat" type="action" value="3">Giao hàng thành công</button> | 
            <button class="btn btn-sm btn-outline-secondary" name="xuat" type="action" value="4">Giao hàng thất bại</button> | 
            <button class="btn btn-sm btn-outline-secondary" name="xuat" type="action" value="5">Huỷ đơn hàng</button> | 
            <button class="btn btn-sm btn-outline-secondary" name="xn" type="action" value="8">Xác nhận</button> | 
            <button class="btn btn-sm btn-outline-secondary" name="xn" type="action" value="9">Chưa xác nhận</button> 


        </form>
    </div>
</div>

<table class="table" style="width: 100%;" border="1">
    <tr style="text-align: center;">
        <th scope="col">ID</th>
        <th scope="col">Ngày đặt</th>
        <th scope="col">Số hóa đơn</th>
        <th scope="col">Tên người nhận</th>
        <th scope="col">Địa chỉ</th>
        <th scope="col">Số điện thoại</th>
       
        <th scope="col">Thành tiền</th>
       
        <th scope="col">Trạng thái</th>
        <th scope="col">Trạng thái đơn hàng</th>
        <th scope="col">Thao tác</th>
    </tr>
    <tbody style="line-height: 40px; height: 40px;">
    <?php foreach ($hoaDon as $index => $hd): ?>
    <tr>
        <td style="text-align: center;"><?php echo $hd['MaHD']; ?></td>
        <td><?php echo $hd['NgayLapHD']; ?></td>
        <td style="text-align: center;"><?php echo $hd['SoHoaDon']; ?></td>
        <td><?php echo $hd['TenNguoiNhan']; ?></td>
        <td><?php echo $hd['DiaChi']; ?></td>
        <td><?php echo $hd['SDT']; ?></td>
        <td style="text-align: center;"><?php echo $hd['ThanhTien']; ?></td>
        <td style="text-align: center;"><?php echo $hd['TrangThai']; ?></td>
        <td><?php echo $hd['TrangThaiDonHang']; ?></td>
        <td style="width: 100%; display: flex; justify-content: flex-end; align-items: center;">
            <button class="button2 update-btn" 
                    data-bs-toggle="modal" 
                    data-bs-target="#detailModal" 
                    data-id="<?php echo $hd['MaHD']; ?>" 
                    data-makh="<?php echo $hd['MaKH']; ?>" 
                    data-ngaylaphd="<?php echo $hd['NgayLapHD']; ?>" 
                    data-sohoadon="<?php echo $hd['SoHoaDon']; ?>" 
                    data-tennguoinhan="<?php echo $hd['TenNguoiNhan']; ?>" 
                    data-diachi="<?php echo $hd['DiaChi']; ?>" 
                    data-sdt="<?php echo $hd['SDT']; ?>" 
                    data-email="<?php echo $hd['Email']; ?>" 
                    data-thanhtien="<?php echo $hd['ThanhTien']; ?>" 
                    data-ghichu="<?php echo $hd['GhiChu']; ?>" 
                    data-trangthai="<?php echo $hd['TrangThai']; ?>"
                    data-trangthaidonhang="<?php echo $hd['TrangThaiDonHang']; ?>"
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-down-left-circle" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-5.904-2.854a.5.5 0 1 1 .707.708L6.707 9.95h2.768a.5.5 0 1 1 0 1H5.5a.5.5 0 0 1-.5-.5V6.475a.5.5 0 1 1 1 0v2.768z"/>
                </svg>
            </button>
        </td>
    </tr>
<?php endforeach; ?>

</tbody>
</table>

<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 800px;height:700px">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Chi Tiết Hóa Đơn</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <p>Mã hoá đơn: <input type="text" class="form-control" id="updateMaHDModal" name="MaHD" readonly></p>
                            <p>Mã khách hàng: <input type="text" class="form-control" id="updateMaKH" name="MaKH" readonly></p>
                            <p>Ngày lập hoá đơn: <input type="text" class="form-control" id="updateNgayLapHD" name="NgayLapHD" readonly></p>
                            <p>Số hoá đơn: <input type="text" class="form-control" id="updateSoHoaDon" name="SoHoaDon"></p>
                            <p>Tên người nhận: <input type="text" class="form-control" id="updateTenNguoiNhan" name="TenNguoiNhan"></p>
                            <p>Địa chỉ: <input type="text" class="form-control" id="updateDiaChi" name="DiaChi"></p>
                        </div>
                        <div class="col-md-6">
                            <p>Số điện thoại: <input type="text" class="form-control" id="updateSDT" name="SDT"></p>
                            <p>Email: <input type="text" class="form-control" id="updateEmail" name="Email"></p>
                            <p>Thành tiền: <input type="text" class="form-control" id="updateThanhTien" name="ThanhTien"></p>
                            <p>Ghi chú: <input type="text" class="form-control" id="updateGhiChu" name="GhiChu"></p>
                            <div class="mb-3">
                                <label for="updateTrangThai" class="form-label">Trạng thái</label>
                                <select class="form-select" id="updateTrangThai" name="TrangThai">
                                    <option value="0"></option>
                                    <option value="1">Xác nhận</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="updateTrangThaiDonHang" class="form-label">Trạng thái đơn hàng</label>
                                <select class="form-select" id="updateTrangThaiDonHang" name="TrangThaiDonHang">
                                    <option value="Đã xác nhận">Đã xác nhận</option>
                                    <option value="Đang giao hàng">Đang giao hàng</option>
                                    <option value="Giao hàng thành công">Giao hàng thành công</option>
                                    <option value="Giao hàng thất bại">Giao hàng thất bại</option>
                                    <option value="Đã hủy">Đã hủy</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="cta" name="update-btn">Cập nhật</button>
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
    const updateButtons = document.querySelectorAll('.update-btn');
    updateButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            const maHD = this.getAttribute('data-id');
            const maKH = this.getAttribute('data-makh');
            const ngayLapHD = this.getAttribute('data-ngaylaphd');
            const soHoaDon = this.getAttribute('data-sohoadon');
            const tenNguoiNhan = this.getAttribute('data-tennguoinhan');
            const diaChi = this.getAttribute('data-diachi');
            const sdt = this.getAttribute('data-sdt');
            const email = this.getAttribute('data-email');
            const thanhTien = this.getAttribute('data-thanhtien');
            const ghiChu = this.getAttribute('data-ghichu');
            const trangThai = this.getAttribute('data-trangthai');
            const trangThaiDonHang = this.getAttribute('data-trangthaidonhang');
            
            // Điền giá trị vào các trường input trong modal
            document.getElementById('updateMaHDModal').value = maHD;
            document.getElementById('updateMaKH').value = maKH;
            document.getElementById('updateNgayLapHD').value = ngayLapHD;
            document.getElementById('updateSoHoaDon').value = soHoaDon;
            document.getElementById('updateTenNguoiNhan').value = tenNguoiNhan;
            document.getElementById('updateDiaChi').value = diaChi;
            document.getElementById('updateSDT').value = sdt;
            document.getElementById('updateEmail').value = email;
            document.getElementById('updateThanhTien').value = thanhTien;
            document.getElementById('updateGhiChu').value = ghiChu;
            document.getElementById('updateTrangThai').value = trangThai;
            document.getElementById('updateTrangThaiDonHang').value = trangThaiDonHang;
            
            // Mở modal
            var myModal = new bootstrap.Modal(document.getElementById('detailModal'));
            myModal.show();
        });
    });
});






    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
  </body>
</html>
