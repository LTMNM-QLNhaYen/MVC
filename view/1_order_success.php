<?php
session_start();
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;
$tenkh = isset($_SESSION['tenkh']) ? $_SESSION['tenkh'] : 'Guest';

$is_logged_in = $user_id !== null;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success</title>
    <link rel="stylesheet" href="styles.css">
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
        <h1>Đặt hàng thành công</h1><br><br>
        <div class="alert alert-success" role="alert">
            Cảm ơn bạn đã đặt hàng tại MyShop! Đơn hàng của bạn đã được đặt thành công.
        </div>
        <a href="../view/1_TrangChu.php" class="btn btn-primary">Quay lại trang chủ</a>
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

    document.getElementById('user-name').textContent = userName;
</script>
</body>
</html>
