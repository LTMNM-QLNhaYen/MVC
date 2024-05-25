<?php
session_start();

// Kiểm tra xem có yêu cầu POST không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra xem người dùng đã đăng nhập chưa
    if (isset($_SESSION['user_id'])) {
        // Nhận mã sản phẩm, mã khách hàng và số lượng từ yêu cầu POST
        $maSP = $_POST['maSP'];
        $soLuong = $_POST['soLuong'];
        $maKH = $_SESSION['user_id']; // Sử dụng mã khách hàng từ session

        // Thực hiện thêm sản phẩm vào giỏ hàng trong cơ sở dữ liệu
        include_once '../model/DB.php';
        include_once '../controller/SanPham_TrongGioHang_con.php';

        $db = new DB();
        $sanPhamTrongGioHangController = new SanPham_TrongGioHang_con($db);

        // Thêm sản phẩm vào giỏ hàng
        $result = $sanPhamTrongGioHangController->themSanPhamVaoGioHang($maSP, $maKH, $soLuong);

        // Trả về phản hồi cho trình duyệt
        if ($result) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('success' => false, 'error' => 'Failed to add product to cart'));
        }

    } else {
        // Nếu người dùng chưa đăng nhập, trả về phản hồi lỗi
        echo json_encode(array('success' => false, 'error' => 'User not logged in'));
    }
} else {
    // Nếu không phải là yêu cầu POST, trả về phản hồi lỗi
    echo json_encode(array('success' => false, 'error' => 'Invalid request method'));
}
?>
