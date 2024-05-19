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
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . "
            SET
                TenKH = :TenKH,
                Phai = :Phai,
                NgaySinh = :NgaySinh,
                DiaChi = :DiaChi,
                SDT = :SDT,
                UserName = :UserName,
                MatKhau = :MatKhau,
                Email = :Email,
                TrangThai = :TrangThai";

        $stmt = $this->conn->prepare($query);

        $this->TenKH = htmlspecialchars(strip_tags($this->TenKH));
        $this->Phai = htmlspecialchars(strip_tags($this->Phai));
        $this->NgaySinh = htmlspecialchars(strip_tags($this->NgaySinh));
        $this->DiaChi = htmlspecialchars(strip_tags($this->DiaChi));
        $this->SDT = htmlspecialchars(strip_tags($this->SDT));
        $this->UserName = htmlspecialchars(strip_tags($this->UserName));
        $this->MatKhau = htmlspecialchars(strip_tags($this->MatKhau));
        $this->Email = htmlspecialchars(strip_tags($this->Email));
        $this->TrangThai = htmlspecialchars(strip_tags($this->TrangThai));

        $stmt->bindParam(':TenKH', $this->TenKH);
        $stmt->bindParam(':Phai', $this->Phai);
        $stmt->bindParam(':NgaySinh', $this->NgaySinh);
        $stmt->bindParam(':DiaChi', $this->DiaChi);
        $stmt->bindParam(':SDT', $this->SDT);
        $stmt->bindParam(':UserName', $this->UserName);
        $stmt->bindParam(':MatKhau', $this->MatKhau);
        $stmt->bindParam(':Email', $this->Email);
        $stmt->bindParam(':TrangThai', $this->TrangThai);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table;

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function update() {
        $query = "UPDATE " . $this->table . "
            SET
                TenKH = :TenKH,
                Phai = :Phai,
                NgaySinh = :NgaySinh,
                DiaChi = :DiaChi,
                SDT = :SDT,
                UserName = :UserName,
                MatKhau = :MatKhau,
                Email = :Email,
                TrangThai = :TrangThai
            WHERE
                MaKH = :MaKH";

        $stmt = $this->conn->prepare($query);

        $this->MaKH = htmlspecialchars(strip_tags($this->MaKH));
        $this->TenKH = htmlspecialchars(strip_tags($this->TenKH));
        $this->Phai = htmlspecialchars(strip_tags($this->Phai));
        $this->NgaySinh = htmlspecialchars(strip_tags($this->NgaySinh));
        $this->DiaChi = htmlspecialchars(strip_tags($this->DiaChi));
        $this->SDT = htmlspecialchars(strip_tags($this->SDT));
        $this->UserName = htmlspecialchars(strip_tags($this->UserName));
        $this->MatKhau = htmlspecialchars(strip_tags($this->MatKhau));
        $this->Email = htmlspecialchars(strip_tags($this->Email));
        $this->TrangThai = htmlspecialchars(strip_tags($this->TrangThai));

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

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE MaKH = :MaKH";

        $stmt = $this->conn->prepare($query);

        $this->MaKH = htmlspecialchars(strip_tags($this->MaKH));

        $stmt->bindParam(':MaKH', $this->MaKH);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);

        return false;
    }
}
?>
