<?php
require_once("../model/PhieuNhap.php");

class PhieuNhapController {
    private $db;
    private $phieuNhapModel;

    public function __construct($db) {
        $this->db = $db;
        $this->phieuNhapModel = new PhieuNhap($db);
    }

    public function create($MaNV, $NgayNhap, $MaPhieuDat, $TongTien, $TrangThai) {
        $this->phieuNhapModel->MaNV = $MaNV;
        $this->phieuNhapModel->NgayNhap = $NgayNhap;
        $this->phieuNhapModel->MaPhieuDat = $MaPhieuDat;
        $this->phieuNhapModel->TongTien = $TongTien;
        $this->phieuNhapModel->TrangThai = $TrangThai;

        return $this->phieuNhapModel->create();
    }

    public function read() {
        return $this->phieuNhapModel->read();
    }

    public function readSingle($MaPhieuNhap) {
        $this->phieuNhapModel->MaPhieuNhap = $MaPhieuNhap;
        $this->phieuNhapModel->readSingle();
        return [
            "MaNV" => $this->phieuNhapModel->MaNV,
            "NgayNhap" => $this->phieuNhapModel->NgayNhap,
            "MaPhieuDat" => $this->phieuNhapModel->MaPhieuDat,
            "TongTien" => $this->phieuNhapModel->TongTien,
            "TrangThai" => $this->phieuNhapModel->TrangThai
        ];
    }

    public function update($MaPhieuNhap, $MaNV, $NgayNhap, $MaPhieuDat, $TongTien, $TrangThai) {
        $this->phieuNhapModel->MaPhieuNhap = $MaPhieuNhap;
        $this->phieuNhapModel->MaNV = $MaNV;
        $this->phieuNhapModel->NgayNhap = $NgayNhap;
        $this->phieuNhapModel->MaPhieuDat = $MaPhieuDat;
        $this->phieuNhapModel->TongTien = $TongTien;
        $this->phieuNhapModel->TrangThai = $TrangThai;

        return $this->phieuNhapModel->update();
    }

    public function delete($MaPhieuNhap) {
        $this->phieuNhapModel->MaPhieuNhap = $MaPhieuNhap;
        return $this->phieuNhapModel->delete();
    }
}
?>
