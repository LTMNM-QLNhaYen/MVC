  <?php
   //session_start();
    include_once '../model/DB.php';
    include_once '../controller/LoaiSanPham_con.php';

    include_once '../controller/SanPham_con.php';

    include_once '../controller/HangSanXuat_con.php';

    include_once '../controller/TinTuc_con.php';
    include_once '../controller/SanPham_TrongGioHang_con.php';

    include_once '../controller/ChiTiet_SanPham_HangSanXuat_con.php';

    $db = new DB();


    // Khởi tạo đối tượng SanPhamController và đọc dữ liệu từ cơ sở dữ liệu
    $sanPhamController = new SanPhamController($db);
    $page = isset($_GET['page']) ? $_GET['page'] : 1; // Trang hiện tại, mặc định là trang 1
    $limit = 10; // Số sản phẩm mỗi trang
    $start = ($page - 1) * $limit; // Vị trí bắt đầu của kết quả truy vấn

    $total_records = $sanPhamController->count(); // Tổng số sản phẩm

    $total_pages = ceil($total_records / $limit); // Tổng số trang

    $sanPham = $sanPhamController->readPerPage($start, $limit);

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search-btn'])) {
        $sanPham = $sanPhamController->findByName($_GET['search']);
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
                <li><a href="#">Giới Thiệu</a></li>
                <li><a href="../view/1_LienHe.php">Liên hệ</a></li>
            </ul>
        </nav>
        <div class="user-actions">
        <form method="GET" action="../view/1_TrangSanPham.php">
            <input type="text" name="search" placeholder="Search...">
            <button type="submit" name="search-btn">Search</button>
        </form>

            <button id="login-button">Login</button>
            <button id="cart-button">Giỏ hàng</button>
        </div>
    </header>

    <div class="banner">
        <div class="banner-slide"><img src="../image/4.jpg" alt="Banner 1"></div>
        <div class="banner-slide"><img src="../image/5.jpg" alt="Banner 2"></div>
        <div class="banner-slide"><img src="../image/3.jpg" alt="Banner 3"></div>
    </div>

    <div class="welcome-section">
        <h2>Welcome to MyShop</h2>
        <p>Your one-stop shop for all your needs. Explore our wide range of products and enjoy great deals.</p>
    </div>

    <div class="container">
        <aside class="sidebar">
            <h2>Loại sản phẩm</h2>
            <ul>
            <li><a href="../view/1_TrangSanPham.php?category=1">Vật liệu</a></li>
                <li><a href="../view/1_TrangSanPham.php?category=2">Loa nhà yến</a></li>
                <li><a href="../view/1_TrangSanPham.php?category=3">Máy tạo ẩm</a></li>
                <li><a href="../view/1_TrangSanPham.php?category=4">Thiết bị điện</a></li>
                <li><a href="../view/1_TrangSanPham.php?category=5">Dung dịch tạo mùi</a></li>
                <li><a href="../view/1_TrangSanPham.php?category=6">Amply nhà yến</a></li>
                <li><a href="../view/1_TrangSanPham.php?category=7">Máy phun béc</a></li>
            </ul>
        </aside>

        <main>
    <section class="product-list">
        <h2>Sản phẩm</h2>
        <div class="products">
            <?php foreach ($sanPham as $sp): ?>
            <!-- Hiển thị thông tin sản phẩm -->
            <div class="product-item" data-masp="<?php echo $sp['MaSP']; ?>">
            <img  src="../image/sanpham/<?php echo $sp['ImageUrl']; ?>" alt="<?php echo $sp['TenSP']; ?>">
            <h3><?php echo $sp['TenSP']; ?></h3>
            <p><?php echo number_format($sp['GiaBan'], 0, ',', '.'); ?> VNĐ</p>
                <button class="add-to-cart-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
                        <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9z"/>
                        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                    </svg>
                </button>
         
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <br>
    <br>
    <div class="pagination">
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?page=<?php echo $i; ?>" <?php if ($i == $page) echo 'class="active"'; ?>><?php echo $i; ?></a>
    <?php endfor; ?>
    </div>

</main>

<!-- Hiển thị phân trang -->

    </div>

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
        $(document).ready(function(){
            $('.banner').slick({
                dots: true,
                infinite: true,
                speed: 500,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
            });
        });



        
    </script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Lấy tất cả các phần tử sản phẩm và gán sự kiện click cho mỗi phần tử
    document.querySelectorAll('.product-item').forEach(function(item) {
        item.addEventListener('click', function() {
            // Lấy mã sản phẩm từ thuộc tính data-masp
            var masp = this.getAttribute('data-masp');
            // Chuyển hướng đến trang chi tiết sản phẩm với mã sản phẩm tương ứng
            window.location.href = '../view/1_ChiTietSanPham.php?MaSP=' + masp;
        });
    });
});
</script>
<script>
    document.getElementById('login-button').addEventListener('click', function() {
        window.location.href = '../view/1_DangNhap.php';
    });
</script>
</body>
</html>

