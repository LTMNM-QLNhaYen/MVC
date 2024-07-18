<?php
require_once("../model/DB.php");
require_once("../model/HoaDon.php");


class HoaDonController {
    private $db;
    private $table_name = "HoaDon";

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($data) {
        $hoaDon = new HoaDon($this->db);
        
        $hoaDon->MaKH = $data['MaKH'];
        $hoaDon->NgayLapHD = $data['NgayLapHD'];
        $hoaDon->TenNguoiNhan = $data['TenNguoiNhan'];
        $hoaDon->DiaChi = $data['DiaChi'];
        $hoaDon->SDT = $data['SDT'];
        $hoaDon->Email = $data['Email'];
        $hoaDon->ThanhTien = $data['ThanhTien'];
        $hoaDon->GhiChu = $data['GhiChu'];
        $hoaDon->TrangThai = $data['TrangThai'];
        $hoaDon->TrangThaiDonHang = $data['TrangThaiDonHang'];

        return $hoaDon->create();
    }

    public function read() {
        $hoaDon = new HoaDon($this->db);
        return $hoaDon->read();
    }

    public function readSingle($MaHD) {
        $hoaDon = new HoaDon($this->db);
        $hoaDon->MaHD = $MaHD;
        $hoaDon->readSingle();
        return $hoaDon;
    }

    public function update($data) {
        $hoaDon = new HoaDon($this->db);
        
        $hoaDon->MaHD = $data['MaHD'];
        $hoaDon->MaKH = $data['MaKH'];
        $hoaDon->NgayLapHD = $data['NgayLapHD'];
        $hoaDon->TenNguoiNhan = $data['TenNguoiNhan'];
        $hoaDon->DiaChi = $data['DiaChi'];
        $hoaDon->SDT = $data['SDT'];
        $hoaDon->Email = $data['Email'];
        $hoaDon->ThanhTien = $data['ThanhTien'];
        $hoaDon->GhiChu = $data['GhiChu'];
        $hoaDon->TrangThai = $data['TrangThai'];
        $hoaDon->TrangThaiDonHang = $data['TrangThaiDonHang'];

        return $hoaDon->update();
    }

    public function delete($MaHD) {
        $hoaDon = new HoaDon($this->db);
        $hoaDon->MaHD = $MaHD;
        return $hoaDon->delete();
    }

    public function getAllAscendingByDate() {
        $hoaDon = new HoaDon($this->db);
        return $hoaDon->getAllAscendingByDate();
    }

    public function getAllDescendingByDate() {
        $hoaDon = new HoaDon($this->db);
        return $hoaDon->getAllDescendingByDate();
    }

    public function searchByTenNguoiNhan($tenNguoiNhan) {
        $hoaDon = new HoaDon($this->db);
        return $hoaDon->searchByTenNguoiNhan($tenNguoiNhan);
    }

    public function getByTrangThaiDonHang($trangThaiDonHang) {
        $hoaDon = new HoaDon($this->db);
        return $hoaDon->getByTrangThaiDonHang($trangThaiDonHang);
    }

    public function getByTrangThai($trangThai) {
        $hoaDon = new HoaDon($this->db);
        return $hoaDon->getByTrangThai($trangThai);
    }

    public function getByMaHoaDon($maHD) {
        $hoaDon = new HoaDon($this->db);
        return $hoaDon->getByMaHoaDon($maHD);
    }

    public function xacNhanHoaDon($maHD, $maNV) {
        $hoaDon = new HoaDon($this->db);
        return $hoaDon->xacNhanHoaDon($maHD, $maNV);
    }


    public function themHoaDon($maKH, $tenNguoiNhan, $diaChi, $sdt, $email, $thanhTien, $ghiChu) {
        $sql = "INSERT INTO HoaDon (MaKH, NgayLapHD, TenNguoiNhan, DiaChi, SDT, Email, ThanhTien, GhiChu, TrangThai, TrangThaiDonHang) 
                VALUES (:MaKH, NOW(), :TenNguoiNhan, :DiaChi, :SDT, :Email, :ThanhTien, :GhiChu, 1, 'Chờ xử lý')";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':MaKH', $maKH, PDO::PARAM_INT);
        $stmt->bindParam(':TenNguoiNhan', $tenNguoiNhan, PDO::PARAM_STR);
        $stmt->bindParam(':DiaChi', $diaChi, PDO::PARAM_STR);
        $stmt->bindParam(':SDT', $sdt, PDO::PARAM_STR);
        $stmt->bindParam(':Email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':ThanhTien', $thanhTien, PDO::PARAM_INT);
        $stmt->bindParam(':GhiChu', $ghiChu, PDO::PARAM_STR);
        $stmt->execute();
        return $this->db->getPdo()->lastInsertId();

    }
    
    
    
}
?>
