<?php 
require_once '../model/DB.php';
require_once '../model/NhanVien.php';
require_once '../controller/NhanVien_con.php';

$db = new DB();
$controller = new NhanVienController($db);

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
                <h4>Thêm thông tin nhân viên</h4>

                <form class="row g-3" method="POST" action="Them_NhanVien.php" enctype="multipart/form-data" name="add_NV">
                    <div class="col-12">
                        <label for="ten" class="form-label">Họ và tên</label>
                        <input type="text" class="form-control" id="ten" name="ten">
                    </div>
                    <div class="col-12">
                        <label for="sdt" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="sdt" name="sdt">
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
