<?php
require_once 'model/HoaDon.php';

class HoaDonController {
    private $model;

    public function __construct($db) {
        $this->model = new HoaDon($db);
    }

    public function create($data) {
        $this->model->MaKH = $data['MaKH'];
        $this->model->NgayLapHD = $data['NgayLapHD'];
        $this->model->SoHoaDon = $data['SoHoaDon'];
        $this->model->TenNguoiNhan = $data['TenNguoiNhan'];
        $this->model->DiaChi = $data['DiaChi'];
        $this->model->SDT = $data['SDT'];
        $this->model->Email = $data['Email'];
        $this->model->ThanhTien = $data['ThanhTien'];
        $this->model->GhiChu = $data['GhiChu'];
        $this->model->TrangThai = $data['TrangThai'];
        $this->model->TrangThaiDonHang = $data['TrangThaiDonHang'];

        if ($this->model->create()) {
            return true;
        }

        return false;
    }

    public function read() {
        return $this->model->read();
    }

    public function update($data) {
        $this->model->MaHD = $data['MaHD'];
        $this->model->MaKH = $data['MaKH'];
        $this->model->NgayLapHD = $data['NgayLapHD'];
        $this->model->SoHoaDon = $data['SoHoaDon'];
        $this->model->TenNguoiNhan = $data['TenNguoiNhan'];
        $this->model->DiaChi = $data['DiaChi'];
        $this->model->SDT = $data['SDT'];
        $this->model->Email = $data['Email'];
        $this->model->ThanhTien = $data['ThanhTien'];
        $this->model->GhiChu = $data['GhiChu'];
        $this->model->TrangThai = $data['TrangThai'];
        $this->model->TrangThaiDonHang = $data['TrangThaiDonHang'];

        if ($this->model->update()) {
            return true;
        }

        return false;
    }

    public function delete($id) {
        $this->model->MaHD = $id;

        if ($this->model->delete()) {
            return true;
        }

        return false;
    }
}
?>
