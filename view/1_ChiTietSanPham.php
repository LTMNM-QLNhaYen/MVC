<?php
   session_start();
   $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : null;
    $tenkh = isset($_SESSION['tenkh']) ? $_SESSION['tenkh'] : 'Guest';

    $is_logged_in = $user_id !== null;

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
            <button class="btn-user" id="cart-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#0092E4" class="bi bi-cart2" viewBox="0 0 16 16">
                    <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l1.25 5h8.22l1.25-5zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0"/>
                </svg>
            </button>
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
   // Lấy giá trị is_logged_in từ PHP
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
