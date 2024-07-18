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


    $sanPhamTrongGioHangController = new SanPham_TrongGioHang_con($db);

// Lấy danh sách sản phẩm trong giỏ hàng của người dùng
    $gioHang = $sanPhamTrongGioHangController->layDanhSachSanPhamTrongGioHang($user_id);
    

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['DatHang-btn'])) {
        $soLuong = $_POST['SoLuong'];
        
        if (!$user_id) {
            echo "Bạn cần đăng nhập để thực hiện chức năng này.";
            exit;
        }
    
        foreach ($gioHang as $item) {
            $sanPhamTrongGioHangController->updateGioHang($user_id, $item['MaSP'], $soLuong);
        }
    
        // Điều hướng đến trang thanh toán hoặc thông báo thành công
        header('Location: ../view/1_ThanhToan.php');
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
<style>
.cart-items {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); /* Adjust the column width as needed */
    gap: 20px; /* Adjust the gap between items */
}

.cart-item {
    border: 1px solid #ccc;
    padding: 20px;
}

.product-image img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 5px;
}

.product-details {
    margin-top: 10px;
}

.product-name {
    font-weight: bold;
}

.product-price, .subtotal-price {
    color: #333;
}

.quantity-input {
    width: 50px;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
    text-align: center;
}

.remove-item-btn {
    background-color: #ff6666;
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
}

.remove-item-btn:hover {
    background-color: #cc0000;
}



</style>
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
        <h1>Giỏ hàng</h1><br>
        <?php if ($gioHang): ?>
            <div class="cart-items">
                <?php foreach ($gioHang as $item): ?>
                    <form method="post" action="">
                    <div class="cart-item">
                    <div class="product-image">
                        <img src="../image/sanpham/<?php echo $item['ImageUrl']; ?>" alt="<?php echo $item['TenSP']; ?>">
                    </div>
                    <div class="product-details">
                        <h3 class="product-name"><?php echo $item['TenSP']; ?></h3>
                        <p class="product-price">Đơn giá : <?php echo number_format($item['GiaBan'], 0, ',', '.'); ?> VNĐ</p>
                        <div class="quantity">
                        <input type="number" class="quantity-input" name="SoLuong[<?php echo $item['MaSP']; ?>]" value="<?php echo $item['SoLuong']; ?>" min="1">

                        </div>
                        <div class="subtotal">
                            <p class="subtotal-price">Thành tiền : <?php echo number_format($item['SoLuong'] * $item['GiaBan'], 0, ',', '.'); ?> VNĐ</p>
                        </div>
                        <div class="actions">
                            <input type="hidden" name="MaSP[]" class="product-id-input" value="<?php echo $item['MaSP']; ?>">
                            <button class="remove-item-btn">Remove</button>
                        </div>
                    </div>
                </div>

                <?php endforeach; ?>
            </div><br><br>
                 <button class="btn btn-info " name="DatHang-btn">Đặt hàng</button>
</form>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </main> 
</div>  <br>

<!-- Hiển thị phân trang -->


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
<script>
    // Thêm sự kiện click vào nút "Remove"
document.querySelectorAll('.remove-item-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var productId = this.parentElement.querySelector('.product-id-input').value; // Lấy ID sản phẩm từ thẻ input ẩn
        var userId = <?php echo json_encode($user_id); ?>; // Lấy mã khách hàng từ biến session
        // Gửi request POST đến server để xoá sản phẩm
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../controller/remove_from_cart.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Nếu request thành công, reload lại trang để cập nhật giỏ hàng
                window.location.reload();
            } else {
                // Xử lý lỗi nếu có
                console.error('Error:', xhr.statusText);
            }
        };
        xhr.onerror = function() {
            // Xử lý lỗi kết nối
            console.error('Request failed');
        };
        // Gửi ID sản phẩm và mã khách hàng cần xoá
        xhr.send('product_id=' + productId + '&user_id=' + userId);
    });
});


</script>
</body>
</html>

