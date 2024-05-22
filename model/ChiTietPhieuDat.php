<?php
require_once("DB.php");

class ChiTietPhieuDat {
    private $conn;
    private $table = "ChiTietPhieuDat";

    public $MaPhieuDat;
    public $MaSanPham;
    public $SoLuong;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " SET MaPhieuDat=:MaPhieuDat, MaSanPham=:MaSanPham, SoLuong=:SoLuong";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':MaPhieuDat', $this->MaPhieuDat);
        $stmt->bindParam(':MaSanPham', $this->MaSanPham);
        $stmt->bindParam(':SoLuong', $this->SoLuong);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            // Handle the exception, log error, or return false
            return false;
        }
    }

    public function readByMaPhieuDat($MaPhieuDat) {
        $query = "SELECT * FROM " . $this->table . " WHERE MaPhieuDat = :MaPhieuDat";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':MaPhieuDat', $MaPhieuDat);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
