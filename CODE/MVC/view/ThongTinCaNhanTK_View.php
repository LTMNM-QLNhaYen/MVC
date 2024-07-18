<?php
// Include tệp kết nối cơ sở dữ liệu và mô hình
include_once '../model/DB.php';
include_once '../model/TaiKhoanNV.php';
include_once '../controller/TaiKhoanNV_con.php';

$db = new DB();

$taiKhoanNVController = new TaiKhoanNVController($db);

session_start();
$UserName = $_SESSION['UserName']; 

if (!isset($_SESSION['UserName'])) {
  // Nếu không đăng nhập, chuyển hướng đến trang đăng nhập
  header("Location: Login_Admin.php");
  exit(); // Dừng kịch bản để chuyển hướng được thực hiện
}

//Thông tin user
$accountInfo = $taiKhoanNVController->getByUserName1($UserName);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update-btn'])) {
    if (isset($_POST['UserName']) ) {

    $data = [
        'UserName' => $_POST['UserName'],
        'MatKhau' => $_POST['MatKhau'],
        'MaNV' => $_POST['MaNV'],
        'maquyen' => $_POST['maquyen'],
        'TrangThai' => $_POST['TrangThai']
    ];
    $taiKhoanNVController->update1($data);

} else {
    // Nếu thiếu trường dữ liệu, hiển thị thông báo hoặc thực hiện hành động phù hợp
    echo "Vui lòng điền đầy đủ thông tin!";
}
}
?>

<!doctype html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
  <head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6hIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <title>Quản lý thông tin cá nhân</title>
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
      <div class="row shadow-lg p- mb-5 bg-body-tertiary rou3nded">
        <div class="col-2">
          <div id="sidebar"></div>
        </div>
      
        <div class="col-10" style="padding: 20px 20px 20px 10px;">
        

        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        
        <div class="mb-3">
                <label for="updateMaNV" class="form-label">Nhân viên</label>
                <input type="text" class="form-control" id="updateMaNV" name="MaNV" 
                value="<?php echo $accountInfo['MaNV']?>"
                readonly="readonly">
                </div>
                
          <input type="hidden" name="UserName" id="updateUserName">
          <div class="mb-3">
            <label for="updateUserNameModal" class="form-label">Tên Đăng Nhập</label>
            <input type="text" class="form-control" id="updateUserNameModal" 
            value="<?php echo $accountInfo['UserName']?>"
            
            name="UserName" readonly="readonly">
          </div>
          <div class="mb-3">
            <label for="updateMatKhau" class="form-label">Mật Khẩu</label>
            <input type="password" class="form-control" id="updateMatKhau" 
            value="<?php echo $accountInfo['MatKhau']?>"
            name="MatKhau">
          </div>
          
          <div class="mb-3">
            <label for="updateMaQuyen" class="form-label">Mã Quyền</label>
            <input type="text" class="form-control" id="updateMaQuyen" name="maquyen" 
            value="<?php echo $accountInfo['maquyen']?>"
            readonly="readonly">
          </div>
          <div class="mb-3">
            <label for="updateTrangThai" class="form-label">Trạng Thái</label>
            <select class="form-select" id="updateTrangThai" 
            name="TrangThai">
                <option value="On" <?php if ($accountInfo['TrangThai'] == 'On') echo 'selected'; ?>>On</option>
                <option value="Off" <?php if ($accountInfo['TrangThai'] == 'Off') echo 'selected'; ?>>Off</option>
            </select>
        </div>

          <button type="submit" class="btn btn-primary" name="update-btn">Cập Nhật</button>
        </form>

          
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
