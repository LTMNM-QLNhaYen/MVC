<?php 
class ChiTietHoaDonController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function themChiTietHoaDon($maHD, $maSP, $soLuong, $giaBan, $thanhTien) {
        $sql = "INSERT INTO ChiTietHoaDon (MaHD, MaSP, SoLuong, GiaBan, ThanhTien) 
                VALUES (:MaHD, :MaSP, :SoLuong, :GiaBan, :ThanhTien)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':MaHD', $maHD, PDO::PARAM_INT);
        $stmt->bindParam(':MaSP', $maSP, PDO::PARAM_INT);
        $stmt->bindParam(':SoLuong', $soLuong, PDO::PARAM_INT);
        $stmt->bindParam(':GiaBan', $giaBan, PDO::PARAM_INT);
        $stmt->bindParam(':ThanhTien', $thanhTien, PDO::PARAM_INT);
        $stmt->execute();
    }
    
}


?>