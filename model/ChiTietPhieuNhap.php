<?php
require_once("DB.php");

class ChiTietPhieuNhap {
    private $conn;
    private $table = "ChiTietPhieuNhap";

    public $MaPhieuNhap;
    public $MaSP;
    public $SoLuong;
    public $GiaNhap;
    public $ThanhTien;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " SET MaPhieuNhap=:MaPhieuNhap, MaSP=:MaSP, SoLuong=:SoLuong, GiaNhap=:GiaNhap, ThanhTien=:ThanhTien";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':MaPhieuNhap', $this->MaPhieuNhap);
        $stmt->bindParam(':MaSP', $this->MaSP);
        $stmt->bindParam(':SoLuong', $this->SoLuong);
        $stmt->bindParam(':GiaNhap', $this->GiaNhap);
        $stmt->bindParam(':ThanhTien', $this->ThanhTien);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            // Handle the exception, log error, or return false
            return false;
        }
    }

    public function readByMaPhieuNhap($MaPhieuNhap) {
        $query = "SELECT * FROM " . $this->table . " WHERE MaPhieuNhap = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $MaPhieuNhap);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
