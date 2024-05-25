<?php
require_once '../model/KhachHang.php';

class KhachHangController {
    private $model;

    public function __construct($db) {
        $this->model = new KhachHang($db);
    }

    public function create($data) {
        $this->model->TenKH = $data['TenKH'];
        $this->model->Phai = $data['Phai'];
        $this->model->NgaySinh = $data['NgaySinh'];
        $this->model->DiaChi = $data['DiaChi'];
        $this->model->SDT = $data['SDT'];
        $this->model->UserName = $data['UserName'];
        $this->model->MatKhau = $data['MatKhau'];
        $this->model->Email = $data['Email'];
        $this->model->TrangThai = $data['TrangThai'];
        return $this->model->create();
    }

    public function read() {
        return $this->model->read();
    }

    public function update($data) {
        $this->model->MaKH = $data['MaKH'];
        $this->model->TenKH = $data['TenKH'];
        $this->model->Phai = $data['Phai'];
        $this->model->NgaySinh = $data['NgaySinh'];
        $this->model->DiaChi = $data['DiaChi'];
        $this->model->SDT = $data['SDT'];
        $this->model->UserName = $data['UserName'];
        $this->model->MatKhau = $data['MatKhau'];
        $this->model->Email = $data['Email'];
        $this->model->TrangThai = $data['TrangThai'];
        return $this->model->update();
    }

    public function delete($MaKH) {
        $this->model->MaKH = $MaKH;
        return $this->model->delete();
    }

    public function searchByName($tenKH) {
        return $this->model->searchByName($tenKH);
    }

    public function getAllAscending() {
        return $this->model->getAllAscending();
    }

    public function getAllDescending() {
        return $this->model->getAllDescending();
    }

    public function Checklogin($UserName, $MatKhau) {
        return $this->model->checkLogin($UserName, $MatKhau);

    }
}
?>
