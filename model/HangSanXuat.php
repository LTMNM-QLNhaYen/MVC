<?php

require_once("DB.php");
 
class HangSanXuat {
    private $db;
    public $MaHSX;
    public $TenHSX;
    public $DiaChi;
    public $SDT;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create() {
        $sql = "INSERT INTO HangSanXuat (TenHSX, DiaChi, SDT) VALUES (:TenHSX, :DiaChi, :SDT)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':TenHSX', $this->TenHSX);
        $stmt->bindParam(':DiaChi', $this->DiaChi);
        $stmt->bindParam(':SDT', $this->SDT);

        return $stmt->execute();
    }

    public function read() {
        $sql = "SELECT * FROM HangSanXuat";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readSingle() {
        $sql = "SELECT * FROM HangSanXuat WHERE MaHSX = :MaHSX";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':MaHSX', $this->MaHSX);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->TenHSX = $row['TenHSX'];
            $this->DiaChi = $row['DiaChi'];
            $this->SDT = $row['SDT'];
        }
    }

    public function update() {
        $sql = "UPDATE HangSanXuat SET TenHSX = :TenHSX, DiaChi = :DiaChi, SDT = :SDT WHERE MaHSX = :MaHSX";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':MaHSX', $this->MaHSX);
        $stmt->bindParam(':TenHSX', $this->TenHSX);
        $stmt->bindParam(':DiaChi', $this->DiaChi);
        $stmt->bindParam(':SDT', $this->SDT);

        return $stmt->execute();
    }

    public function delete() {
        $sql = "DELETE FROM HangSanXuat WHERE MaHSX = :MaHSX";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':MaHSX', $this->MaHSX);

        return $stmt->execute();
    }

   

   
  
    public function searchByTenHSX($tenHSX) {
        $sql = "SELECT * FROM HangSanXuat WHERE TenHSX LIKE :tenHSX";
        $stmt = $this->db->prepare($sql);
        $tenHSX = "%$tenHSX%";
        $stmt->bindParam(':tenHSX', $tenHSX);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllAscending() {
        $sql = "SELECT * FROM HangSanXuat ORDER BY MaHSX ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllDescending() {
        $sql = "SELECT * FROM HangSanXuat ORDER BY MaHSX DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>
