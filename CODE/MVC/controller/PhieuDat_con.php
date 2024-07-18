<?php
require_once("../model/PhieuDat.php");

class PhieuDatController {
    private $db;
    private $phieuDatModel;

    public function __construct($db) {
        $this->db = $db;
        $this->phieuDatModel = new PhieuDat($db);
    }

    public function create($NgayLap, $TrangThai, $MaHSX) {
        $this->phieuDatModel->NgayLap = $NgayLap;
        $this->phieuDatModel->TrangThai = $TrangThai;
        $this->phieuDatModel->MaHSX = $MaHSX;

        return $this->phieuDatModel->create();
    }

    public function readAll() {
        return $this->phieuDatModel->readAll();
    }
}
?>
