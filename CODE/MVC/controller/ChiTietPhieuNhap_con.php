<?php
require_once("../model/ChiTietPhieuNhap.php");

class ChiTietPhieuNhapController {
    private $db;
    private $chiTietPhieuNhapModel;

    public function __construct($db) {
        $this->db = $db;
        $this->chiTietPhieuNhapModel = new ChiTietPhieuNhap($db);
    }

    public function create($MaPhieuNhap, $MaSP, $SoLuong, $GiaNhap, $ThanhTien) {
        $this->chiTietPhieuNhapModel->MaPhieuNhap = $MaPhieuNhap;
        $this->chiTietPhieuNhapModel->MaSP = $MaSP;
        $this->chiTietPhieuNhapModel->SoLuong = $SoLuong;
        $this->chiTietPhieuNhapModel->GiaNhap = $GiaNhap;
        $this->chiTietPhieuNhapModel->ThanhTien = $ThanhTien;

        return $this->chiTietPhieuNhapModel->create();
    }

    public function readByMaPhieuNhap($MaPhieuNhap) {
        return $this->chiTietPhieuNhapModel->readByMaPhieuNhap($MaPhieuNhap);
    }
}
?>

