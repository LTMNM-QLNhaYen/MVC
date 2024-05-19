<?php
require_once("DB.php");

class HoaDon {
    private $conn;
    private $table = "HoaDon";

    public $MaHD;
    public $MaKH;
    public $NgayLapHD;
    public $SoHoaDon;
    public $TenNguoiNhan;
    public $DiaChi;
    public $SDT;
    public $Email;
    public $ThanhTien;
    public $GhiChu;
    public $TrangThai;
    public $TrangThaiDonHang;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . "
            SET
                MaKH = :MaKH,
                NgayLapHD = :NgayLapHD,
                SoHoaDon = :SoHoaDon,
                TenNguoiNhan = :TenNguoiNhan,
                DiaChi = :DiaChi,
                SDT = :SDT,
                Email = :Email,
                ThanhTien = :ThanhTien,
                GhiChu = :GhiChu,
                TrangThai = :TrangThai,
                TrangThaiDonHang = :TrangThaiDonHang";

        $stmt = $this->conn->prepare($query);

        $this->MaKH = htmlspecialchars(strip_tags($this->MaKH));
        $this->NgayLapHD = htmlspecialchars(strip_tags($this->NgayLapHD));
        $this->SoHoaDon = htmlspecialchars(strip_tags($this->SoHoaDon));
        $this->TenNguoiNhan = htmlspecialchars(strip_tags($this->TenNguoiNhan));
        $this->DiaChi = htmlspecialchars(strip_tags($this->DiaChi));
        $this->SDT = htmlspecialchars(strip_tags($this->SDT));
        $this->Email = htmlspecialchars(strip_tags($this->Email));
        $this->ThanhTien = htmlspecialchars(strip_tags($this->ThanhTien));
        $this->GhiChu = htmlspecialchars(strip_tags($this->GhiChu));
        $this->TrangThai = htmlspecialchars(strip_tags($this->TrangThai));
        $this->TrangThaiDonHang = htmlspecialchars(strip_tags($this->TrangThaiDonHang));

        $stmt->bindParam(':MaKH', $this->MaKH);
        $stmt->bindParam(':NgayLapHD', $this->NgayLapHD);
        $stmt->bindParam(':SoHoaDon', $this->SoHoaDon);
        $stmt->bindParam(':TenNguoiNhan', $this->TenNguoiNhan);
        $stmt->bindParam(':DiaChi', $this->DiaChi);
        $stmt->bindParam(':SDT', $this->SDT);
        $stmt->bindParam(':Email', $this->Email);
        $stmt->bindParam(':ThanhTien', $this->ThanhTien);
        $stmt->bindParam(':GhiChu', $this->GhiChu);
        $stmt->bindParam(':TrangThai', $this->TrangThai);
        $stmt->bindParam(':TrangThaiDonHang', $this->TrangThaiDonHang);

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
                MaKH = :MaKH,
                NgayLapHD = :NgayLapHD,
                SoHoaDon = :SoHoaDon,
                TenNguoiNhan = :TenNguoiNhan,
                DiaChi = :DiaChi,
                SDT = :SDT,
                Email = :Email,
                ThanhTien = :ThanhTien,
                GhiChu = :GhiChu,
                TrangThai = :TrangThai,
                TrangThaiDonHang = :TrangThaiDonHang
            WHERE
                MaHD = :MaHD";

        $stmt = $this->conn->prepare($query);

        $this->MaHD = htmlspecialchars(strip_tags($this->MaHD));
        $this->MaKH = htmlspecialchars(strip_tags($this->MaKH));
        $this->NgayLapHD = htmlspecialchars(strip_tags($this->NgayLapHD));
        $this->SoHoaDon = htmlspecialchars(strip_tags($this->SoHoaDon));
        $this->TenNguoiNhan = htmlspecialchars(strip_tags($this->TenNguoiNhan));
        $this->DiaChi = htmlspecialchars(strip_tags($this->DiaChi));
        $this->SDT = htmlspecialchars(strip_tags($this->SDT));
        $this->Email = htmlspecialchars(strip_tags($this->Email));
        $this->ThanhTien = htmlspecialchars(strip_tags($this->ThanhTien));
        $this->GhiChu = htmlspecialchars(strip_tags($this->GhiChu));
        $this->TrangThai = htmlspecialchars(strip_tags($this->TrangThai));
        $this->TrangThaiDonHang = htmlspecialchars(strip_tags($this->TrangThaiDonHang));

        $stmt->bindParam(':MaHD', $this->MaHD);
        $stmt->bindParam(':MaKH', $this->MaKH);
        $stmt->bindParam(':NgayLapHD', $this->NgayLapHD);
        $stmt->bindParam(':SoHoaDon', $this->SoHoaDon);
        $stmt->bindParam(':TenNguoiNhan', $this->TenNguoiNhan);
        $stmt->bindParam(':DiaChi', $this->DiaChi);
        $stmt->bindParam(':SDT', $this->SDT);
        $stmt->bindParam(':Email', $this->Email);
        $stmt->bindParam(':ThanhTien', $this->ThanhTien);
        $stmt->bindParam(':GhiChu', $this->GhiChu);
        $stmt->bindParam(':TrangThai', $this->TrangThai);
        $stmt->bindParam(':TrangThaiDonHang', $this->TrangThaiDonHang);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE MaHD = :MaHD";

        $stmt = $this->conn->prepare($query);

        $this->MaHD = htmlspecialchars(strip_tags($this->MaHD));

        $stmt->bindParam(':MaHD', $this->MaHD);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);

        return false;
    }
}
?>

