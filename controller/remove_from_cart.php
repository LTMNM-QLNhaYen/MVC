<?php
session_start();

// Kiểm tra xem có phải request method POST không
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Kiểm tra xem có sản phẩm ID và mã khách hàng được gửi đến không
    if (isset($_POST['product_id']) && isset($_SESSION['user_id'])) {
        // Lấy sản phẩm ID và mã khách hàng từ dữ liệu gửi đến
        $productId = $_POST['product_id'];
        $userId = $_SESSION['user_id'];

        // Kết nối đến cơ sở dữ liệu
        include_once '../model/DB.php';
        include_once '../controller/SanPham_TrongGioHang_con.php';

        $db = new DB();

        // Xoá sản phẩm khỏi giỏ hàng trong cơ sở dữ liệu
        $sanPhamTrongGioHangController = new SanPham_TrongGioHang_con($db);
        $result = $sanPhamTrongGioHangController->xoaSanPhamTrongGioHang($productId, $userId);

        if ($result) {
            // Nếu sản phẩm được xoá thành công, cập nhật lại giỏ hàng trong session
            updateCartInSession();
            // Trả về thông báo thành công cho client
            echo 'Product removed successfully.';
        } else {
            // Nếu có lỗi xảy ra trong quá trình xoá sản phẩm
            echo 'Failed to remove product from cart.';
        }
    } else {
        // Nếu không có sản phẩm ID hoặc mã khách hàng được gửi đến
        echo 'Invalid request.';
    }
} else {
    // Nếu không phải là request method POST
    echo 'Invalid request method.';
}

// Hàm cập nhật giỏ hàng trong session sau khi xóa sản phẩm ra khỏi cơ sở dữ liệu
function updateCartInSession() {
    // Lấy lại danh sách sản phẩm trong giỏ hàng của khách hàng từ cơ sở dữ liệu
    // Sau đó cập nhật lại giỏ hàng trong session
}
?>
