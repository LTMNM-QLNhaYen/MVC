<?php
require_once 'model/HangSanXuat.php';

class HangSanXuatController {
    private $model;

    public function __construct($db) {
        $this->model = new HangSanXuat($db);
    }

    public function create($data) {
        $this->model->TenHSX = $data['TenHSX'];
        $this->model->DiaChi = $data['DiaChi'];
        $this->model->SDT = $data['SDT'];

        if ($this->model->create()) {
            return true;
        }

        return false;
    }

    public function read() {
        return $this->model->read();
    }

    public function update($data) {
        $this->model->MaHSX = $data['MaHSX'];
        $this->model->TenHSX = $data['TenHSX'];
        $this->model->DiaChi = $data['DiaChi'];
        $this->model->SDT = $data['SDT'];

        if ($this->model->update()) {
            return true;
        }

        return false;
    }

    public function delete($id) {
        $this->model->MaHSX = $id;

        if ($this->model->delete()) {
            return true;
        }

        return false;
    }
}
?>
