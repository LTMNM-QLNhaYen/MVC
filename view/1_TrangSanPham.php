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
    $limit = 20; // Số sản phẩm mỗi trang
    $start = ($page - 1) * $limit; // Vị trí bắt đầu của kết quả truy vấn

    $total_records = $sanPhamController->count(); // Tổng số sản phẩm

    $total_pages = ceil($total_records / $limit); // Tổng số trang

    $sanPham = $sanPhamController->readPerPage($start, $limit);

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search-btn'])) {
        $sanPham = $sanPhamController->findByName($_GET['search']);
    }
    

   // In 1_TrangSanPham.php

        $category = isset($_GET['category']) ? $_GET['category'] : null;
        if ($category) {
            $total_records = $sanPhamController->countByCategory($category);
            // Thực hiện phân trang và lấy danh sách sản phẩm theo loại sản phẩm
            // Sử dụng $category để lọc sản phẩm theo loại này
            $sanPham = $sanPhamController->findByCategory($category, $start, $limit);
        } else {
            $total_records = $sanPhamController->count(); // Lấy tổng số sản phẩm
            // Lấy danh sách sản phẩm mặc định nếu không có lọc theo loại sản phẩm
            $sanPham = $sanPhamController->readPerPage($start, $limit);
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
    
    <div class="welcome-section" style="margin-top:90px">
        <h2>Lựa chọn sản phẩm</h2>
        <p>Uy tín cửa hàng là chất lượng sản phẩm.</p>
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
        <div class="row">
            <div class="col-6"><h2>Sản phẩm</h2></div>
            <div class="col-6">
              <div class="sort-buttons">
                <button class="sort-button" id="sort-price">Sắp xếp theo giá</button>
                <button  class="sort-button" id="sort-name">Sắp xếp theo tên</button>
            </div>  
            </div>
        </div>
        <br>
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
    document.addEventListener('DOMContentLoaded', function() {
        // Lấy danh sách các sản phẩm
        var products = document.querySelectorAll('.product-item');

        // Biến đánh dấu thứ tự sắp xếp
        var ascending = true;

        // Sắp xếp theo giá thành
        document.getElementById('sort-price').addEventListener('click', function() {
            // Chuyển đổi NodeList thành mảng để sử dụng sort()
            var productsArray = Array.from(products);
            // Sắp xếp mảng theo giá thành
            productsArray.sort(function(a, b) {
                var priceA = parseFloat(a.querySelector('p').textContent.replace(' VNĐ', '').replace('.', '').replace(',', ''));
                var priceB = parseFloat(b.querySelector('p').textContent.replace(' VNĐ', '').replace('.', '').replace(',', ''));
                if (ascending) {
                    return priceA - priceB;
                } else {
                    return priceB - priceA;
                }
            });
            // Đảo ngược thứ tự sắp xếp
            ascending = !ascending;
            // Xóa tất cả các sản phẩm trong container
            products.forEach(function(product) {
                product.parentNode.removeChild(product);
            });
            // Thêm lại các sản phẩm đã sắp xếp vào container
            productsArray.forEach(function(product) {
                document.querySelector('.products').appendChild(product);
            });
        });

        // Sắp xếp theo tên
        document.getElementById('sort-name').addEventListener('click', function() {
            // Chuyển đổi NodeList thành mảng để sử dụng sort()
            var productsArray = Array.from(products);
            // Sắp xếp mảng theo tên
            productsArray.sort(function(a, b) {
                var nameA = a.querySelector('h3').textContent.toUpperCase();
                var nameB = b.querySelector('h3').textContent.toUpperCase();
                if (ascending) {
                    return nameA.localeCompare(nameB);
                } else {
                    return nameB.localeCompare(nameA);
                }
            });
            // Đảo ngược thứ tự sắp xếp
            ascending = !ascending;
            // Xóa tất cả các sản phẩm trong container
            products.forEach(function(product) {
                product.parentNode.removeChild(product);
            });
            // Thêm lại các sản phẩm đã sắp xếp vào container
            productsArray.forEach(function(product) {
                document.querySelector('.products').appendChild(product);
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

