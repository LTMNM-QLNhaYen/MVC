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

        if ($this->model->create()) {
            return true;
        }

        return false;
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

        if ($this->model->update()) {
            return true;
        }

        return false;
    }

    public function delete($id) {
        $this->model->MaKH = $id;

        if ($this->model->delete()) {
            return true;
        }

        return false;
    }
}
?>
