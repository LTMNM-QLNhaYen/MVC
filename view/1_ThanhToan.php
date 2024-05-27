<?php
session_start();
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;
$tenkh = isset($_SESSION['tenkh']) ? $_SESSION['tenkh'] : 'Guest';

$is_logged_in = $user_id !== null;

include_once '../model/DB.php';
include_once '../controller/SanPham_TrongGioHang_con.php';
include_once '../controller/HoaDon_con.php';
include_once '../controller/ChiTietHoaDon_con.php';

$db = new DB();

// Khởi tạo đối tượng HoaDonController và SanPhamTrongGioHangController
$hoaDonController = new HoaDonController($db);
$sanPhamTrongGioHangController = new SanPham_TrongGioHang_con($db);

// Lấy danh sách sản phẩm trong giỏ hàng của người dùng
$gioHang = $sanPhamTrongGioHangController->layDanhSachSanPhamTrongGioHang1($user_id);

// Khởi tạo biến tổng tiền
$total_amount = 0;

// Kiểm tra giá trị của $total_amount trước khi tính tổng tiền

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order'])) {
    // Thêm thông tin đơn hàng vào bảng HoaDon
    $tenNguoiNhan = $_POST['TenNguoiNhan'];
    $diaChi = $_POST['DiaChi'];
    $sdt = $_POST['SDT'];
    $email = $_POST['Email'];
    $ghiChu = $_POST['GhiChu'];
    
    // Tính lại tổng tiền
    foreach ($gioHang as $item) {
        $total_amount += $item['SoLuong'] * $item['GiaBan'];
    }
    $thanhTien = $total_amount; // tổng tiền đã được tính toán

    // Thêm hóa đơn và lấy ID của hóa đơn vừa thêm
    $maHD = $hoaDonController->themHoaDon($user_id, $tenNguoiNhan, $diaChi, $sdt, $email, $thanhTien, $ghiChu);

    // Thêm sản phẩm vào chi tiết hóa đơn
    $chiTietHoaDonController = new ChiTietHoaDonController($db);
    foreach ($gioHang as $item) {
        $chiTietHoaDonController->themChiTietHoaDon($maHD, $item['MaSP'], $item['SoLuong'], $item['GiaBan'], $item['SoLuong'] * $item['GiaBan']);
    }

    // Xóa giỏ hàng sau khi đặt hàng thành công
    $sanPhamTrongGioHangController->xoaGioHang($user_id);

    // Redirect hoặc thông báo đặt hàng thành công
    header('Location: 1_order_success.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce Website</title>
    <link rel="stylesheet" href="styles.css">
    <!-- Slick Slider CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
</head>
<body>
<header>
    <div class="logo">
        <h1>MyShop</h1>
    </div>
    <nav>
        <ul class="menu">
            <li><a href="../view/1_TrangChu.php">Trang chủ</a></li>
            <li><a href="../view/1_TrangSanPham.php">Sản phẩm</a></li>
            <li><a href="">Giới Thiệu</a></li>
            <li><a href="../view/1_LienHe.php">Liên hệ</a></li>
        </ul>
    </nav>
    <div class="user-actions">
        <form method="GET" action="../view/1_TrangSanPham.php" class="search-form">
            <input class="input-search" type="text" name="search" placeholder="Search...">
            <button type="submit" class="btn-user" name="search-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#0092E4" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                </svg>
            </button>
        </form>

            <button class="btn-user" id="login-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#0092E4" class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                </svg>
                <span id="user-name">User Name</span>
            </button>
            <button class="btn-user" id="cart-button" onclick="location.href='../view/1_GioHang.php'">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#0092E4" class="bi bi-cart2" viewBox="0 0 16 16">
                    <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l1.25 5h8.22l1.25-5zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0"/>
                </svg>
            </button>
        </div>

</header>
<br><br><br><br><br>
<div class="container">
    <main>
        <h1>Đặt hàng</h1><br><br>
        <div class="row">
            <div class="col-2">
            </div>
            <div class="col-10">
                <h2>Thông tin đặt hàng</h2>
                <form class="row g-3" action="" method="POST">
                    <div class="col-md-6">
                        <label for="inputName" class="form-label">Tên người nhận</label>
                        <input type="text" class="form-control" id="inputName" name="TenNguoiNhan" required>
                    </div>
                    <div class="col-12">
                        <label for="inputAddress" class="form-label">Địa chỉ giao hàng</label>
                        <input type="text" class="form-control" id="inputAddress" name="DiaChi" placeholder="1234 Main St" required>
                    </div>
                    <div class="col-md-6">
                        <label for="inputPhone" class="form-label">Số điện thoại</label>
                        <input type="number" class="form-control" id="inputPhone" name="SDT" pattern="[0-9]{10}" required title="Số điện thoại phải có 10 chữ số">
<small id="phoneError" style="color: red; display: none;">Số điện thoại không hợp lệ.</small>
                    </div>
                    <div class="col-md-6">
                        <label for="inputEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="inputEmail" name="Email" pattern="[a-zA-Z0-9._%+-]+@gmail\.com" required>
                    </div>
                    <div class="col-12">
                        <label for="inputNote" class="form-label">Ghi chú</label>
                        <textarea class="form-control" id="inputNote" name="GhiChu"></textarea>
                    </div>
                    <input type="hidden" name="ThanhTien" value="<?php echo $total_amount; ?>">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary" name="order">Đặt hàng</button>
                    </div>
                </form>
            </div>
        </div>
        <br>
        <h2>Danh sách sản phẩm đặt hàng</h2>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tên sản phẩm</th>
                <th scope="col">Số lượng</th>
                <th scope="col">Giá</th>
                <th scope="col">Thành tiền</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($gioHang as $item): ?>
                <tr>
                    <th scope="row"><?php echo $item['MaSP']; ?></th>
                    <td><?php echo $item['TenSP']; ?></td>
                    <td><?php echo $item['SoLuong']; ?></td>
                    <td><?php echo number_format($item['GiaBan']); ?></td>
                    <td><?php echo number_format($item['SoLuong'] * $item['GiaBan']); ?></td>
                </tr>
                <?php 
                // Tính tổng số tiền bằng cách cộng số tiền của mỗi sản phẩm
                $total_amount += $item['SoLuong'] * $item['GiaBan']; 
                ?>
            <?php endforeach; ?>
            </tbody>
        </table>
<br> <br>        <p>Tổng tiền: <span style="color:red"><b><?php echo number_format($total_amount); ?></b></span></p>


    </main>
</div>
<br>
<footer>
    <div class="footer-content">
        <h3>About MyShop</h3>
        <p>MyShop is your go-to destination for quality products at amazing prices. We strive to provide the best shopping experience for our customers.</p>
    </div>
    <p>&copy; 2024 MyShop. All rights reserved.</p>
</footer>
<!-- Slick Slider JS -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<script>
     var isLoggedIn = <?php echo json_encode($is_logged_in); ?>;
        var userName = <?php echo json_encode($tenkh); ?>;

        document.getElementById('login-button').addEventListener('click', function() {
            if (isLoggedIn) {
                window.location.href = '../view/1_ThongTinCaNhan.php';
            } else {
                window.location.href = '../view/1_DangNhap.php';
            }
        });

        // Đặt tên người dùng nếu có trong session
        document.getElementById('user-name').textContent = userName;
</script>



</body>
</html>
