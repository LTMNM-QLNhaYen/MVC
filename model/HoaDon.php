<?php
require_once("DB.php");

class HoaDon {
    private $db;
    public $MaHD;
    public $MaKH;
    public $NgayLapHD;
    public $TenNguoiNhan;
    public $DiaChi;
    public $SDT;
    public $Email;
    public $ThanhTien;
    public $GhiChu;
    public $TrangThai;
    public $TrangThaiDonHang;

    public function __construct($db) {
        $this->db = $db;
        $this->conn = $this->db->getConnection(); // Gán giá trị cho thuộc tính $conn
    }
    
    
    public function create() {
        $sql = "INSERT INTO HoaDon (MaKH, NgayLapHD, TenNguoiNhan, DiaChi, SDT, Email, ThanhTien, GhiChu, TrangThai, TrangThaiDonHang) VALUES (:MaKH, :NgayLapHD, :SoHoaDon, :TenNguoiNhan, :DiaChi, :SDT, :Email, :ThanhTien, :GhiChu, :TrangThai, :TrangThaiDonHang)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':MaKH', $this->MaKH);
        $stmt->bindParam(':NgayLapHD', $this->NgayLapHD);
        $stmt->bindParam(':TenNguoiNhan', $this->TenNguoiNhan);
        $stmt->bindParam(':DiaChi', $this->DiaChi);
        $stmt->bindParam(':SDT', $this->SDT);
        $stmt->bindParam(':Email', $this->Email);
        $stmt->bindParam(':ThanhTien', $this->ThanhTien);
        $stmt->bindParam(':GhiChu', $this->GhiChu);
        $stmt->bindParam(':TrangThai', $this->TrangThai);
        $stmt->bindParam(':TrangThaiDonHang', $this->TrangThaiDonHang);

        return $stmt->execute();
    }

    public function read() {
        $sql = "SELECT * FROM HoaDon";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readSingle() {
        $sql = "SELECT * FROM HoaDon WHERE MaHD = :MaHD";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':MaHD', $this->MaHD);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->MaKH = $row['MaKH'];
            $this->NgayLapHD = $row['NgayLapHD'];
            $this->TenNguoiNhan = $row['TenNguoiNhan'];
            $this->DiaChi = $row['DiaChi'];
            $this->SDT = $row['SDT'];
            $this->Email = $row['Email'];
            $this->ThanhTien = $row['ThanhTien'];
            $this->GhiChu = $row['GhiChu'];
            $this->TrangThai = $row['TrangThai'];
            $this->TrangThaiDonHang = $row['TrangThaiDonHang'];
        }
    }

    public function update() {
        $sql = "UPDATE HoaDon SET MaKH = :MaKH, NgayLapHD = :NgayLapHD, TenNguoiNhan = :TenNguoiNhan, DiaChi = :DiaChi, SDT = :SDT, Email = :Email, ThanhTien = :ThanhTien, GhiChu = :GhiChu, TrangThai = :TrangThai, TrangThaiDonHang = :TrangThaiDonHang WHERE MaHD = :MaHD";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':MaHD', $this->MaHD);
        $stmt->bindParam(':MaKH', $this->MaKH);
        $stmt->bindParam(':NgayLapHD', $this->NgayLapHD);
        $stmt->bindParam(':TenNguoiNhan', $this->TenNguoiNhan);
        $stmt->bindParam(':DiaChi', $this->DiaChi);
        $stmt->bindParam(':SDT', $this->SDT);
        $stmt->bindParam(':Email', $this->Email);
        $stmt->bindParam(':ThanhTien', $this->ThanhTien);
        $stmt->bindParam(':GhiChu', $this->GhiChu);
        $stmt->bindParam(':TrangThai', $this->TrangThai);
        $stmt->bindParam(':TrangThaiDonHang', $this->TrangThaiDonHang);

        return $stmt->execute();
    }

    public function delete() {
        $sql = "DELETE FROM HoaDon WHERE MaHD = :MaHD";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':MaHD', $this->MaHD);

        return $stmt->execute();
    }

    public function getTotalThanhTien() {
        $query = "SELECT SUM(ThanhTien) as totalThanhTien FROM  HoaDon ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['totalThanhTien'];
    }

    public function countHoaDon() {
        $query = "SELECT COUNT(*) as totalHoaDon FROM HoaDon " ;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['totalHoaDon'];
    }


    public function getAllAscendingByDate() {
        $sql = "SELECT * FROM HoaDon ORDER BY NgayLapHD ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllDescendingByDate() {
        $sql = "SELECT * FROM HoaDon ORDER BY NgayLapHD DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchByTenNguoiNhan($tenNguoiNhan) {
        $sql = "SELECT * FROM HoaDon WHERE TenNguoiNhan LIKE :tenNguoiNhan";
        $stmt = $this->db->prepare($sql);
        $tenNguoiNhan = "%$tenNguoiNhan%";
        $stmt->bindParam(':tenNguoiNhan', $tenNguoiNhan);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByTrangThaiDonHang($trangThaiDonHang) {
        $sql = "SELECT * FROM HoaDon WHERE TrangThaiDonHang = :trangThaiDonHang";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':trangThaiDonHang', $trangThaiDonHang);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getByTrangThai($trangThai) {
        $sql = "SELECT * FROM HoaDon WHERE TrangThai = :trangThai";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':trangThai', $trangThai, PDO::PARAM_INT); // Đảm bảo truyền vào kiểu INT
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByMaHoaDon($maHD) {
        $sql = "SELECT * FROM ChiTietHoaDon WHERE MaHD = :maHD";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':maHD', $maHD);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function xacNhanHoaDon($maHD, $maNV) {
        $ngayXacNhan = date('Y-m-d H:i:s');
        $sql = "INSERT INTO XacNhanHoaDon (MaHD, MaNV, NgayXacNhan) VALUES (:maHD, :maNV, :ngayXacNhan)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':maHD', $maHD);
        $stmt->bindParam(':maNV', $maNV);
        $stmt->bindParam(':ngayXacNhan', $ngayXacNhan);

        return $stmt->execute();
    }

}
?>

