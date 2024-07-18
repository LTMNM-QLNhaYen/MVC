<?php
require_once("../model/ChiTietPhieuDat.php");

class ChiTietPhieuDatController {
    private $db;
    private $chiTietPhieuDatModel;

    public function __construct($db) {
        $this->db = $db;
        $this->chiTietPhieuDatModel = new ChiTietPhieuDat($db);
    }

    public function create($MaPhieuDat, $MaSanPham, $SoLuong) {
        $this->chiTietPhieuDatModel->MaPhieuDat = $MaPhieuDat;
        $this->chiTietPhieuDatModel->MaSanPham = $MaSanPham;
        $this->chiTietPhieuDatModel->SoLuong = $SoLuong;

        return $this->chiTietPhieuDatModel->create();
    }

    public function readByMaPhieuDat($MaPhieuDat) {
        return $this->chiTietPhieuDatModel->readByMaPhieuDat($MaPhieuDat);
    }
}
?>
