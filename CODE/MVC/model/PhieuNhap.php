<?php
require_once("DB.php");

class PhieuNhap {
    private $conn;
    private $table = "PhieuNhap";

    public $MaPhieuNhap;
    public $MaNV;
    public $NgayNhap;
    public $MaPhieuDat;
    public $TongTien;
    public $TrangThai;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " SET MaNV=:MaNV, NgayNhap=:NgayNhap, MaPhieuDat=:MaPhieuDat, TongTien=:TongTien, TrangThai=:TrangThai";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':MaNV', $this->MaNV);
        $stmt->bindParam(':NgayNhap', $this->NgayNhap);
        $stmt->bindParam(':MaPhieuDat', $this->MaPhieuDat);
        $stmt->bindParam(':TongTien', $this->TongTien);
        $stmt->bindParam(':TrangThai', $this->TrangThai);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            // Handle the exception, log error, or return false
            return false;
        }
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readSingle() {
        $query = "SELECT * FROM " . $this->table . " WHERE MaPhieuNhap = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->MaPhieuNhap);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->MaNV = $row['MaNV'];
            $this->NgayNhap = $row['NgayNhap'];
            $this->MaPhieuDat = $row['MaPhieuDat'];
            $this->TongTien = $row['TongTien'];
            $this->TrangThai = $row['TrangThai'];
        }
    }

    public function update() {
        $query = "UPDATE " . $this->table . " SET MaNV = :MaNV, NgayNhap = :NgayNhap, MaPhieuDat = :MaPhieuDat, TongTien = :TongTien, TrangThai = :TrangThai WHERE MaPhieuNhap = :MaPhieuNhap";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":MaNV", $this->MaNV);
        $stmt->bindParam(":NgayNhap", $this->NgayNhap);
        $stmt->bindParam(":MaPhieuDat", $this->MaPhieuDat);
        $stmt->bindParam(":TongTien", $this->TongTien);
        $stmt->bindParam(":TrangThai", $this->TrangThai);
        $stmt->bindParam(":MaPhieuNhap", $this->MaPhieuNhap);

        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE MaPhieuNhap = :MaPhieuNhap";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":MaPhieuNhap", $this->MaPhieuNhap);

        return $stmt->execute();
    }
}
?>
