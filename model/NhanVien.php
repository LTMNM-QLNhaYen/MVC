<?php
require_once("DB.php");

class NhanVien {
    private $conn;
    private $table = "nhanvien";

    public $MaNV;
    public $TenNV;
    public $Phai;
    public $NgaySinh;
    public $DiaChi;
    public $SDT;
    public $TrangThai;

    public function __construct($db) {
        $this->conn = $db;
    }
    public function create() {
        $query = "INSERT INTO " . $this->table . " SET TenNV=:TenNV, Phai=:Phai, NgaySinh=:NgaySinh, DiaChi=:DiaChi, SDT=:SDT";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(':TenNV', $this->TenNV);
        $stmt->bindParam(':Phai', $this->Phai);
        $stmt->bindParam(':NgaySinh', $this->NgaySinh);
        $stmt->bindParam(':DiaChi', $this->DiaChi);
        $stmt->bindParam(':SDT', $this->SDT);
      
    
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            // Handle the exception, log error, or return false
            return false;
        }
    }
    

    public function read() {
        $sql = "SELECT MaNV, TenNV, Phai, SDT, DiaChi,TrangThai,NgaySinh FROM nhanvien";
        $stmt = $this->conn->prepare($sql); // Use $conn
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readSingle() {
        $query = "SELECT * FROM " . $this->table . " WHERE MaNV = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query); // Use $conn
        $stmt->bindParam(1, $this->MaNV);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->TenNV = $row['TenNV'];
            $this->Phai = $row['Phai'];
            $this->NgaySinh = $row['NgaySinh'];
            $this->DiaChi = $row['DiaChi'];
            $this->SDT = $row['SDT'];
            $this->TrangThai = $row['TrangThai'];
        }
    }

    public function update() {
        $query = "UPDATE " . $this->table . " SET TenNV = :TenNV, Phai = :Phai, NgaySinh = :NgaySinh, DiaChi = :DiaChi, SDT = :SDT, TrangThai = :TrangThai WHERE MaNV = :MaNV";
        $stmt = $this->conn->prepare($query); // Use $conn

        $this->TenNV = htmlspecialchars(strip_tags($this->TenNV));
        $this->Phai = htmlspecialchars(strip_tags($this->Phai));
        $this->NgaySinh = htmlspecialchars(strip_tags($this->NgaySinh));
        $this->DiaChi = htmlspecialchars(strip_tags($this->DiaChi));
        $this->SDT = htmlspecialchars(strip_tags($this->SDT));
        $this->TrangThai = htmlspecialchars(strip_tags($this->TrangThai));
        $this->MaNV = htmlspecialchars(strip_tags($this->MaNV));

        $stmt->bindParam(":TenNV", $this->TenNV);
        $stmt->bindParam(":Phai", $this->Phai);
        $stmt->bindParam(":NgaySinh", $this->NgaySinh);
        $stmt->bindParam(":DiaChi", $this->DiaChi);
        $stmt->bindParam(":SDT", $this->SDT);
        $stmt->bindParam(":TrangThai", $this->TrangThai);
        $stmt->bindParam(":MaNV", $this->MaNV);

        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE MaNV = :MaNV";
        $stmt = $this->conn->prepare($query); // Use $conn

        $this->MaNV = htmlspecialchars(strip_tags($this->MaNV));
        $stmt->bindParam(":MaNV", $this->MaNV);

        return $stmt->execute();
    }

    public function getByGender($gender) {
        $query = "SELECT * FROM " . $this->table . " WHERE Phai = :Phai ORDER BY TenNV";
        $stmt = $this->conn->prepare($query); // Use $conn
        $stmt->bindParam(':Phai', $gender);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllAscending() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY TenNV ASC";
        $stmt = $this->conn->prepare($query); // Use $conn
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllDescending() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY TenNV DESC";
        $stmt = $this->conn->prepare($query); // Use $conn
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchByName($name) {
        $query = "SELECT * FROM " . $this->table . " WHERE TenNV LIKE :searchTerm ORDER BY TenNV";
        $stmt = $this->conn->prepare($query); // Use $conn
        $name = "%$name%";
        $stmt->bindParam(':searchTerm', $name);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
