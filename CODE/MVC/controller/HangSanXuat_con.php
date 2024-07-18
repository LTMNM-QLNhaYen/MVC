<?php
require_once '../model/HangSanXuat.php';

class HangSanXuatController {
    private $model;

    public function __construct($db) {
        $this->model = new HangSanXuat($db);
    }

    public function create($data) {
        $this->model->TenHSX = $data['TenHSX'];
        $this->model->DiaChi = $data['DiaChi'];
        $this->model->SDT = $data['SDT'];
        return $this->model->create();
    }

    public function read() {
        return $this->model->read();
    }

    public function searchByTenHSX($tenHSX) {
        return $this->model->searchByTenHSX($tenHSX);
    }

    public function getAllAscending() {
        return $this->model->getAllAscending();
    }

    public function getAllDescending() {
        return $this->model->getAllDescending();
    }

    public function readSingle($id) {
        $this->model->MaHSX = $id;
        $this->model->readSingle();
        if ($this->model->TenHSX) {
            $item = [
                "MaHSX" => $this->model->MaHSX,
                "TenHSX" => $this->model->TenHSX,
                "DiaChi" => $this->model->DiaChi,
                "SDT" => $this->model->SDT
            ];
            return json_encode($item);
        } else {
            return json_encode(["message" => "Record not found."]);
        }
    }

    public function update($data) {
        $this->model->MaHSX = $data['MaHSX'];
        $this->model->TenHSX = $data['TenHSX'];
        $this->model->DiaChi = $data['DiaChi'];
        $this->model->SDT = $data['SDT'];

        if ($this->model->update()) {
            return json_encode(["message" => "Record updated successfully."]);
        } else {
            return json_encode(["message" => "Failed to update record."]);
        }
    }

    public function delete($id) {
        $this->model->MaHSX = $id;
        if ($this->model->delete()) {
            return json_encode(["message" => "Record deleted successfully."]);
        } else {
            return json_encode(["message" => "Failed to delete record."]);
        }
    }
}
?>
