<?php
require_once("DB.php");

class KhachHang {
    private $conn;
    private $table = "KhachHang";

    public $MaKH;
    public $TenKH;
    public $Phai;
    public $NgaySinh;
    public $DiaChi;
    public $SDT;
    public $UserName;
    public $MatKhau;
    public $Email;
    public $TrangThai;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create() {
        $sql = "INSERT INTO KhachHang (TenKH, Phai, NgaySinh, DiaChi, SDT, UserName, MatKhau, Email, TrangThai) 
                VALUES (:TenKH, :Phai, :NgaySinh, :DiaChi, :SDT, :UserName, :MatKhau, :Email, :TrangThai)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':TenKH', $this->TenKH);
        $stmt->bindParam(':Phai', $this->Phai);
        $stmt->bindParam(':NgaySinh', $this->NgaySinh);
        $stmt->bindParam(':DiaChi', $this->DiaChi);
        $stmt->bindParam(':SDT', $this->SDT);
        $stmt->bindParam(':UserName', $this->UserName);
        $stmt->bindParam(':MatKhau', $this->MatKhau);
        $stmt->bindParam(':Email', $this->Email);
        $stmt->bindParam(':TrangThai', $this->TrangThai);

        return $stmt->execute();
    }

    public function read() {
        $sql = "SELECT * FROM KhachHang";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readSingle() {
        $sql = "SELECT * FROM KhachHang WHERE MaKH = :MaKH";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':MaKH', $this->MaKH);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->TenKH = $row['TenKH'];
            $this->Phai = $row['Phai'];
            $this->NgaySinh = $row['NgaySinh'];
            $this->DiaChi = $row['DiaChi'];
            $this->SDT = $row['SDT'];
            $this->UserName = $row['UserName'];
            $this->MatKhau = $row['MatKhau'];
            $this->Email = $row['Email'];
            $this->TrangThai = $row['TrangThai'];
        }
    }

    public function update() {
        $sql = "UPDATE KhachHang 
                SET TenKH = :TenKH, Phai = :Phai, NgaySinh = :NgaySinh, DiaChi = :DiaChi, SDT = :SDT, UserName = :UserName, MatKhau = :MatKhau, Email = :Email, TrangThai = :TrangThai 
                WHERE MaKH = :MaKH";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':MaKH', $this->MaKH);
        $stmt->bindParam(':TenKH', $this->TenKH);
        $stmt->bindParam(':Phai', $this->Phai);
        $stmt->bindParam(':NgaySinh', $this->NgaySinh);
        $stmt->bindParam(':DiaChi', $this->DiaChi);
        $stmt->bindParam(':SDT', $this->SDT);
        $stmt->bindParam(':UserName', $this->UserName);
        $stmt->bindParam(':MatKhau', $this->MatKhau);
        $stmt->bindParam(':Email', $this->Email);
        $stmt->bindParam(':TrangThai', $this->TrangThai);

        return $stmt->execute();
    }

    public function delete() {
        $sql = "DELETE FROM KhachHang WHERE MaKH = :MaKH";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':MaKH', $this->MaKH);

        return $stmt->execute();
    }

    public function searchByName($tenKH) {
        $sql = "SELECT * FROM KhachHang WHERE TenKH LIKE :tenKH";
        $stmt = $this->db->prepare($sql);
        $tenKH = "%$tenKH%";
        $stmt->bindParam(':tenKH', $tenKH);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllAscending() {
        $sql = "SELECT * FROM KhachHang ORDER BY MaKH ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllDescending() {
        $sql = "SELECT * FROM KhachHang ORDER BY MaKH DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countKhachHang() {
        $query = "SELECT COUNT(*) as totalKhachHang FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['totalKhachHang'];
    }
}
?>
