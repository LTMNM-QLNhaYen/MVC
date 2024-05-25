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
    
    $MaSP = $_GET['MaSP']; // Lấy MaSP từ URL

    // Lấy thông tin sản phẩm dựa trên MaSP
    $sanPham = $sanPhamController->getSanPhamById($MaSP);
    

    ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sản phẩm</title>
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
        <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="text" name="search" placeholder="Search...">
            <button type="submit" name="search-btn">Search</button>
        </form>

            <button id="login-button">Login</button>
            <button id="cart-button">Giỏ hàng</button>
        </div>
    </header>
    <br/><br/><br/>
    <main>
        <div class="product-details1">
        <div class="product-image1">
                <img src="../image/sanpham/<?php echo $sanPham['ImageUrl']; ?>" alt="<?php echo $sanPham['TenSP']; ?>">
            </div>
            <div class="product-info1">
                <h1><?php echo $sanPham['TenSP']; ?></h1>
                <p class="price1"><span style="color:red"><?php echo number_format($sanPham['GiaBan'], 0, ',', '.'); ?> VNĐ</span></p>
                <!-- Thêm các thông tin khác của sản phẩm -->
                <p class="description1"><?php echo $sanPham['MoTa']; ?></p>
                <button class="add-to-cart-btn1">Add to Cart</button>
             
                <button class="contact-link1">Contact Us</button><br>
                <button class="buy-now-btn1">Buy Now</button>

                

            </div>
           
        </div>
        <h3>Thông tin</h3>
        <p class="description1"><?php echo $sanPham['ThongTin']; ?></p>
        <div class="related-products1">
            <h2><b>Gợi ý sản phẩm</b></h2>
            <section class="product-list">
            <div class="products">
            <?php
            // Retrieve random products from the same category
            $relatedProducts = $sanPhamController->getRandomProductsByCategory($sanPham['MaLoai'], 4);

            // Display each related product
            foreach ($relatedProducts as $relatedProduct) {
            ?>
            <div class="product-item" data-masp="<?php echo $relatedProduct['MaSP']; ?>">
                    <img src="../image/sanpham/<?php echo $relatedProduct['ImageUrl']; ?>" alt="<?php echo $relatedProduct['TenSP']; ?>">
                    <h3><?php echo $relatedProduct['TenSP']; ?></h3>
                    <p class="price1"><?php echo number_format($relatedProduct['GiaBan'], 0, ',', '.'); ?> VNĐ</p>
                    <!-- Add any additional information you want to display -->
                </div>
            <?php
            }
            ?></div>
        </section>
            </div>
    </main>

    <footer>
        <div class="footer-content">
            <h3>About MyShop</h3>
            <p>MyShop is your go-to destination for quality products at amazing prices. We strive to provide the best shopping experience for our customers.</p>
        </div>
        <p>&copy; 2024 MyShop. All rights reserved.</p>
    </footer>
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
