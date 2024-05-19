<?php
require_once 'model/PhanQuyen.php';

class PhanQuyenController {
    private $model;

    public function __construct($db) {
        $this->model = new PhanQuyen($db);
    }

    public function create($data) {
        $this->model->MaQuyen = $data['MaQuyen'];
        $this->model->TenQuyen = $data['TenQuyen'];
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
        $this->model->MaQuyen = $data['MaQuyen'];
        $this->model->TenQuyen = $data['TenQuyen'];
        $this->model->TrangThai = $data['TrangThai'];

        if ($this->model->update()) {
            return true;
        }

        return false;
    }

    public function delete($id) {
        $this->model->MaQuyen = $id;

        if ($this->model->delete()) {
            return true;
        }

        return false;
    }
}
?>
