<?php
require_once("../model/SanPham.php");

class SanPhamController {
    private $db;
    private $sanPhamModel;

    public function __construct($db) {
        $this->db = $db;
        $this->sanPhamModel = new SanPham($db);
    }

    public function create($data) {
        $this->sanPhamModel->TenSP = $data['TenSP'];
        $this->sanPhamModel->DonViTinh = $data['DonViTinh'];
        $this->sanPhamModel->GiaBan = $data['GiaBan'];
        $this->sanPhamModel->GiaNhap = $data['GiaNhap'];
        $this->sanPhamModel->TinhTrang = $data['TinhTrang'];
        $this->sanPhamModel->MoTa = $data['MoTa'];
        $this->sanPhamModel->ThongTin = $data['ThongTin'];
        $this->sanPhamModel->ImageUrl = $data['ImageUrl'];
        $this->sanPhamModel->MaLoai = $data['MaLoai'];
        $this->sanPhamModel->TonKho = $data['TonKho'];

        return $this->sanPhamModel->create();
    }

    public function update($data) {
        $this->sanPhamModel->MaSP = $data['MaSP'];
        $this->sanPhamModel->TenSP = $data['TenSP'];
        $this->sanPhamModel->DonViTinh = $data['DonViTinh'];
        $this->sanPhamModel->GiaBan = $data['GiaBan'];
        $this->sanPhamModel->GiaNhap = $data['GiaNhap'];
        $this->sanPhamModel->TinhTrang = $data['TinhTrang'];
        $this->sanPhamModel->MoTa = $data['MoTa'];
        $this->sanPhamModel->ThongTin = $data['ThongTin'];
        $this->sanPhamModel->ImageUrl = $data['ImageUrl'];
        $this->sanPhamModel->MaLoai = $data['MaLoai'];
        $this->sanPhamModel->TonKho = $data['TonKho'];

        return $this->sanPhamModel->update();
    }

    public function delete($maSP) {
        $this->sanPhamModel->MaSP = $maSP;
        return $this->sanPhamModel->delete();
    }

    public function findByName($name) {
        return $this->sanPhamModel->findByName($name);
    }

    public function sortBy($column, $order) {
        return $this->sanPhamModel->sortBy($column, $order);
    }

    public function getAll() {
        return $this->sanPhamModel->getAll();
    }

    public function getByManufacturer($manufacturerId) {
        return $this->sanPhamModel->getByManufacturer($manufacturerId);
    }
}
?>
