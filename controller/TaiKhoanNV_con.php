<?php
require_once 'model/TaiKhoanNV.php';

class TaiKhoanNVController {
    private $model;

    public function __construct($db) {
        $this->model = new TaiKhoanNV($db);
    }

    public function create($data) {
        $this->model->UserName = $data['UserName'];
        $this->model->MatKhau = $data['MatKhau'];
        $this->model->MaNV = $data['MaNV'];
        $this->model->MaQuyen = $data['MaQuyen'];
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
        $this->model->UserName = $data['UserName'];
        $this->model->MatKhau = $data['MatKhau'];
        $this->model->MaNV = $data['MaNV'];
        $this->model->MaQuyen = $data['MaQuyen'];
        $this->model->TrangThai = $data['TrangThai'];

        if ($this->model->update()) {
            return true;
        }

        return false;
    }

    public function delete($id) {
        $this->model->UserName = $id;

        if ($this->model->delete()) {
            return true;
        }

        return false;
    }
}
?>
