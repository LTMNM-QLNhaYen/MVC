<?php
require_once("DB.php");

class SanPham {
    private $conn;
    private $table = "SanPham";

    public $MaSP;
    public $TenSP;
    public $DonViTinh;
    public $GiaBan;
    public $GiaNhap;
    public $TinhTrang;
    public $MoTa;
    public $ThongTin;
    public $ImageUrl;
    public $MaLoai;
    public $TonKho;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($data) {
        $sql = "INSERT INTO SanPham (TenSP, DonViTinh, GiaBan, GiaNhap, TinhTrang, MoTa, ThongTin, ImageUrl, MaLoai, TonKho) 
                VALUES (:TenSP, :DonViTinh, :GiaBan, :GiaNhap, :TinhTrang, :MoTa, :ThongTin, :ImageUrl, :MaLoai, :TonKho)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    public function read() {
        $sql = "SELECT * FROM SanPham";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function update($data) {
        $sql = "UPDATE SanPham SET TenSP = :TenSP, DonViTinh = :DonViTinh, GiaBan = :GiaBan, GiaNhap = :GiaNhap, TinhTrang = :TinhTrang, MoTa = :MoTa, ThongTin = :ThongTin, ImageUrl = :ImageUrl, MaLoai = :MaLoai, TonKho = :TonKho WHERE MaSP = :MaSP";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    public function delete($MaSP) {
        $sql = "DELETE FROM SanPham WHERE MaSP = :MaSP";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['MaSP' => $MaSP]);
    }

    public function searchByName($name) {
        $sql = "SELECT * FROM SanPham WHERE TenSP LIKE :name";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['name' => "%$name%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllAscending() {
        $sql = "SELECT * FROM SanPham ORDER BY TenSP ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getAllDescending() {
        $sql = "SELECT * FROM SanPham ORDER BY TenSP DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function findByName($name) {
        $query = "SELECT * FROM " . $this->table . " WHERE TenSP LIKE :name";
        $stmt = $this->conn->prepare($query);
        $name = "%$name%";
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function sortBy($column, $order) {
        $query = "SELECT * FROM " . $this->table . " ORDER BY $column $order";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByManufacturer($manufacturerId) {
        $query = "SELECT * FROM " . $this->table . " WHERE MaLoai = :manufacturerId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':manufacturerId', $manufacturerId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
