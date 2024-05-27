<?php
session_start();
include_once '../model/DB.php';

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['user_id'])) {
    // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Kết nối đến cơ sở dữ liệu
$db = new DB();

// Lấy thông tin người dùng từ cơ sở dữ liệu
$sql = "SELECT * FROM KhachHang WHERE MaKH = :MaKH";
$stmt = $db->prepare($sql);
$stmt->bindParam(':MaKH', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $tenKH = $_POST['TenKH'];
    $phai = $_POST['Phai'];
    $ngaySinh = $_POST['NgaySinh'];
    $diaChi = $_POST['DiaChi'];
    $sdt = $_POST['SDT'];
    $userName = $_POST['UserName'];
    $email = $_POST['Email'];
    $matKhau = $_POST['MatKhau'];

    // Only hash the password if it's not empty
    if (!empty($matKhau)) {
        $matKhau = password_hash($matKhau, PASSWORD_DEFAULT); // Hash the password
        $sql = "UPDATE KhachHang SET TenKH = ?, Phai = ?, NgaySinh = ?, DiaChi = ?, SDT = ?, UserName = ?, MatKhau = ?, Email = ? WHERE MaKH = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$tenKH, $phai, $ngaySinh, $diaChi, $sdt, $userName, $matKhau, $email, $user_id]);
    } else {
        $sql = "UPDATE KhachHang SET TenKH = ?, Phai = ?, NgaySinh = ?, DiaChi = ?, SDT = ?, UserName = ?, Email = ? WHERE MaKH = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$tenKH, $phai, $ngaySinh, $diaChi, $sdt, $userName, $email, $user_id]);
    }

    if ($stmt->execute()) {
        // Cập nhật thành công
        echo "<script>alert('Thông tin đã được cập nhật thành công.');</script>";
    } else {
        // Cập nhật thất bại
        echo "<script>alert('Có lỗi xảy ra. Vui lòng thử lại.');</script>";
    }
}

// Lấy thông tin đơn hàng của khách hàng từ cơ sở dữ liệu
$sql_order = "SELECT HoaDon.*, ChiTietHoaDon.*, SanPham.TenSP
              FROM HoaDon
              INNER JOIN ChiTietHoaDon ON HoaDon.MaHD = ChiTietHoaDon.MaHD
              INNER JOIN SanPham ON ChiTietHoaDon.MaSP = SanPham.MaSP
              WHERE HoaDon.MaKH = :MaKH";
$stmt_order = $db->prepare($sql_order);
$stmt_order->bindParam(':MaKH', $user_id, PDO::PARAM_INT);
$stmt_order->execute();
$orders_raw = $stmt_order->fetchAll(PDO::FETCH_ASSOC);

// Organize orders and their associated products into an array
$orders = [];
foreach ($orders_raw as $order) {
    $order_id = $order['MaHD'];
    if (!isset($orders[$order_id])) {
        $orders[$order_id] = [
            'MaHD' => $order['MaHD'],
            'NgayLapHD' => $order['NgayLapHD'],
            'TenNguoiNhan' => $order['TenNguoiNhan'],
            'DiaChi' => $order['DiaChi'],
            'SDT' => $order['SDT'],
            'Email' => $order['Email'],
            'ThanhTien' => $order['ThanhTien'],
            'GhiChu' => $order['GhiChu'],
            'TrangThaiDonHang' => $order['TrangThaiDonHang'],
            'products' => []
        ];
    }
    // Add product details to the order
    $orders[$order_id]['products'][] = [
        'TenSP' => $order['TenSP'],
        'SoLuong' => $order['SoLuong'],
        'GiaBan' => $order['GiaBan'],
        'ThanhTien' => $order['ThanhTien'],
        // Add other product details here
    ];
}

// Đóng kết nối cơ sở dữ liệu
$db = null;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin cá nhân</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

   <style>
        .card {
            width: 190px;
            height: 254px;
            background: #F0F8FF;
            border-radius: 15px;
            box-shadow: 1px 5px 10px 0px #A2B5CD;
        }
        .card .card-border-top {
            width: 60%;
            height: 3%;
            background: #B0E2FF;
            margin: auto;
            border-radius: 0px 0px 15px 15px;
        }
        .card span {
            font-weight: 900;
            color: black;
            text-align: center;
            display: block;
            padding-top: 10px;
            font-size: 16px;
        }
        .card .job {
            font-weight: 700;
            color: black;
            display: block;
            text-align: center;
            padding-top: 3px;
            font-size: 15px;
        }
        .card .img {
            width: 70px;
            height: 80px;
            background: #B0E2FF;
            border-radius: 15px;
            margin: auto;
            margin-top: 25px;
        }
        .card button {
            padding: 8px 25px;
            display: block;
            margin: auto;
            border-radius: 8px;
            border: none;
            margin-top: 30px;
            background: #B0E2FF;
            color: white;
            font-weight: 600;
        }
        .card button:hover {
            background: #534bf3;
        }
    </style>
</head>
<body>
    <header>
   

</header>
    <div class="container">
        <br><br>
        <div class="row">
            <div class="col-2">
                <div class="card">
                    <div class="card-border-top"></div>
                    <div class="img"></div>
                    <span style="color:black"> ID : <?php echo $user_id; ?></span>
                    <p class="job"><?php echo $user['UserName']; ?></p>
                    <form method="post" action="1_logout.php">
                    <button type="submit" class="btn btn-primary">Đăng xuất</button>
                </form><br>
                </div>
            </div>
            <div class="col-10">
                <h2>Thông tin cá nhân</h2>
                <form class="row g-3" action="../view/1_ThongTinCaNhan.php" method="POST">
                    <div class="col-md-6">
                        <label for="inputName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="inputName" name="TenKH" value="<?php echo $user['TenKH']; ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="inputGender" class="form-label">Gender</label>
                        <select id="inputGender" class="form-select" name="Phai" required>
                            <option value="Nam" <?php echo ($user['Phai'] == 'Nam') ? 'selected' : ''; ?>>Nam</option>
                            <option value="Nữ" <?php echo ($user['Phai'] == 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="inputBirthDate" class="form-label">Birth Date</label>
                        <input type="date" class="form-control" id="inputBirthDate" name="NgaySinh" value="<?php echo $user['NgaySinh']; ?>">
                    </div>
                    <div class="col-12">
                        <label for="inputAddress" class="form-label">Address</label>
                        <input type="text" class="form-control" id="inputAddress" name="DiaChi" value="<?php echo $user['DiaChi']; ?>" placeholder="1234 Main St" required>
                    </div>
                    <div class="col-md-6">
                        <label for="inputPhone" class="form-label">Số điện thoại</label>
                        <input type="number" class="form-control" id="inputPhone" name="SDT" pattern="[0-9]{10}" required title="Số điện thoại phải có 10 chữ số">
                        <small id="phoneError" style="color: red; display: none;">Số điện thoại không hợp lệ.</small>
                    </div>

                    <script>
                    document.getElementById('inputPhone').addEventListener('input', function (e) {
                        const phoneInput = e.target;
                        const phoneError = document.getElementById('phoneError');
                        
                        if (phoneInput.validity.patternMismatch || phoneInput.value.length !== 10) {
                            phoneError.style.display = 'block';
                        } else {
                            phoneError.style.display = 'none';
                        }
                    });
                    </script>

                    <div class="col-md-6">
                        <label for="inputUsername" class="form-label">Username</label>
                        <input type="text" class="form-control" id="inputUsername" name="UserName" value="<?php echo $user['UserName']; ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="inputEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="inputEmail" name="Email" value="<?php echo $user['Email']; ?>" pattern="[a-zA-Z0-9._%+-]+@gmail\.com" required>
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="inputPassword" name="MatKhau" placeholder="Leave blank if not changing" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}" 
       title="Mật khẩu phải chứa ít nhất một ký tự đặc biệt, một số, một chữ cái in hoa và một chữ cái thường, và có ít nhất 8 ký tự." required>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>

<br> <br>

        <div class="row">
        <h2>Thông tin đơn hàng</h2>

        <?php if (empty($orders)): ?>
                    <p>Hiện không có đơn hàng nào.</p>
                    <a href="../view/1_TrangChu.php">Mua hàng ngay</a>
                <?php else: ?>
            <!-- Display orders here -->
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Mã HD</th>
                        <th scope="col">Ngày lập hóa đơn</th>
                        <th scope="col">Tên người nhận</th>
                        <th scope="col">Địa chỉ</th>
                        <th scope="col">Số điện thoại</th>
                        <th scope="col">Email</th>
                        <th scope="col">Thành tiền</th>
                        <th scope="col">Ghi chú</th>
                        <th scope="col">Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($orders as $order): ?>
    <tr class="<?php echo getRowClass($order['TrangThaiDonHang']); ?>">
        <td><?php echo $order['MaHD']; ?></td>
        <td><?php echo $order['NgayLapHD']; ?></td>
        <td><?php echo $order['TenNguoiNhan']; ?></td>
        <td><?php echo $order['DiaChi']; ?></td>
        <td><?php echo $order['SDT']; ?></td>
        <td><?php echo $order['Email']; ?></td>
        <td><?php echo $order['ThanhTien']; ?></td>
        <td><?php echo $order['GhiChu']; ?></td>
        <td><?php echo $order['TrangThaiDonHang']; ?></td>
        <td colspan="4">
            <!-- Order details modal button -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#orderDetailsModal<?php echo $order['MaHD']; ?>">
                Xem chi tiết
            </button>
            <!-- Order details modal -->
            <div class="modal fade" id="orderDetailsModal<?php echo $order['MaHD']; ?>" tabindex="-1" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <!-- Modal header -->
                        <div class="modal-header">
                            <h5 class="modal-title" id="orderDetailsModalLabel">Chi tiết đơn hàng :  <?php echo $order['MaHD']; ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <!-- Order details table -->
                            <table class="table">
                                <!-- Table headers -->
                                <thead>
                                    <!-- Table row -->
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Giá</th>
                                        <th>Số lượng</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                </thead>
                                <!-- Table body -->
                                <tbody>
                                <?php foreach ($order['products'] as $product): ?>
                                    <!-- Table row for each product -->
                                    <tr>
                                        <!-- Product details -->
                                        <td><?php echo $product['TenSP']; ?></td>
                                        <td><?php echo $product['GiaBan']; ?></td>
                                        <td><?php echo $product['SoLuong']; ?></td>
                                        <td><?php echo $product['ThanhTien']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>
<?php endforeach; ?>

                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
    </div>



</body>
<?php
function getRowClass($status) {
    switch ($status) {
        case 'Chờ xử lý':
            return 'table-warning'; // Màu vàng cho trạng thái Chờ xử lý
            break;
        case 'Đã xác nhận':
            return 'table-info'; // Màu xanh dương cho trạng thái Đã xác nhận
            break;
        case 'Đang giao hàng':
            return 'table-primary'; // Màu xanh lam cho trạng thái Đang giao hàng
            break;
        case 'Giao hàng thất bại':
                return 'table-dark'; // Màu xanh lam cho trạng thái Đang giao hàng
                break;
        case 'Giao hàng thành công':
            return 'table-success'; // Màu xanh lá cây cho trạng thái Hoàn thành
            break;
        case 'Đã hủy':
            return 'table-danger'; // Màu đỏ cho trạng thái Đã hủy
            break;
        default:
            return 'table-danger'; // Trường hợp khác không áp dụng class
            break;
    }
}
?>

</html>