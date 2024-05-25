
<?php

class SanPham_TrongGioHang_con {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Phương thức để thêm sản phẩm vào giỏ hàng
    public function themSanPhamVaoGioHang($maSP, $maKH, $soLuong) {
        try {
            // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng của khách hàng chưa
            $query_check = "SELECT * FROM SanPham_TrongGioHang WHERE MaSP = :maSP AND MaKH = :maKH";
            $stmt_check = $this->db->prepare($query_check);
            $stmt_check->bindParam(':maSP', $maSP, PDO::PARAM_INT);
            $stmt_check->bindParam(':maKH', $maKH, PDO::PARAM_INT);
            $stmt_check->execute();

            if ($stmt_check->rowCount() > 0) {
                // Nếu sản phẩm đã tồn tại, cập nhật số lượng
                $query_update = "UPDATE SanPham_TrongGioHang SET SoLuong = SoLuong + :soLuong WHERE MaSP = :maSP AND MaKH = :maKH";
                $stmt_update = $this->db->prepare($query_update);
                $stmt_update->bindParam(':maSP', $maSP, PDO::PARAM_INT);
                $stmt_update->bindParam(':maKH', $maKH, PDO::PARAM_INT);
                $stmt_update->bindParam(':soLuong', $soLuong, PDO::PARAM_INT);
                $stmt_update->execute();
            } else {
                // Nếu sản phẩm chưa tồn tại, thêm mới vào giỏ hàng
                $query_insert = "INSERT INTO SanPham_TrongGioHang (MaSP, MaKH, SoLuong) VALUES (:maSP, :maKH, :soLuong)";
                $stmt_insert = $this->db->prepare($query_insert);
                $stmt_insert->bindParam(':maSP', $maSP, PDO::PARAM_INT);
                $stmt_insert->bindParam(':maKH', $maKH, PDO::PARAM_INT);
                $stmt_insert->bindParam(':soLuong', $soLuong, PDO::PARAM_INT);
                $stmt_insert->execute();
            }

            return true; // Trả về true nếu thêm sản phẩm vào giỏ hàng thành công
        } catch (PDOException $e) {
            // Xử lý ngoại lệ nếu có lỗi xảy ra
            echo "Error: " . $e->getMessage();
            return false; // Trả về false nếu có lỗi xảy ra
        }
    }


    public function layDanhSachSanPhamTrongGioHang($user_id)
    {
        // Prepare SQL statement to select products in the user's cart
        $sql = "SELECT sp.*, sanpham_tronggiohang.SoLuong
                FROM sanpham sp
                INNER JOIN sanpham_tronggiohang ON sp.MaSP = sanpham_tronggiohang.MaSP
                WHERE sanpham_tronggiohang.MaKH = :user_id";

        // Prepare the query
        $stmt = $this->db->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();

        // Fetch all rows
        $gioHang = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Close the cursor
        $stmt->closeCursor();

        // Return the list of products in the user's cart
        return $gioHang;
    }
    // Trong class SanPham_TrongGioHang_con
public function xoaSanPhamTrongGioHang($productId, $userId) {
    // Câu truy vấn để xoá sản phẩm khỏi giỏ hàng của khách hàng
    $query = "DELETE FROM sanpham_tronggiohang WHERE MaKH = :user_id AND MaSP = :product_id";

    try {
        // Chuẩn bị câu truy vấn
        $stmt = $this->db->prepare($query);

        // Bind giá trị vào câu truy vấn
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":product_id", $productId);

        // Thực thi câu truy vấn
        if ($stmt->execute()) {
            return true; // Nếu xoá thành công, trả về true
        } else {
            return false; // Nếu có lỗi xảy ra, trả về false
        }
    } catch (PDOException $e) {
        // Xử lý nếu có lỗi xảy ra trong quá trình thực thi câu truy vấn
        return false;
    }
}
// Trong file SanPham_TrongGioHang_con.php

public function layDanhSachSanPhamTrongGioHang1($maKH) {
    $sql = "SELECT SanPham.*, sanpham_tronggiohang.SoLuong 
            FROM sanpham_tronggiohang 
            INNER JOIN SanPham ON sanpham_tronggiohang.MaSP = SanPham.MaSP 
            WHERE sanpham_tronggiohang.MaKH = :maKH";
    $params = array(':maKH' => $maKH);
    $result = $this->db->select($sql, $params);
    return $result;
}

}

?>
