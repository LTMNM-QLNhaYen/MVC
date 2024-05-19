<?php
include_once 'model/LoaiSanPham.php';

class LoaiSanPhamController {
    private $model;

    public function __construct($db) {
        $this->model = new LoaiSanPham($db);
    }

    public function create($data) {
        $this->model->TenLoai = $data['TenLoai'];
        $this->model->MoTa = $data['MoTa'];
        if ($this->model->create()) {
            return json_encode(["message" => "Record created successfully."]);
        } else {
            return json_encode(["message" => "Failed to create record."]);
        }
    }

    public function read() {
        $stmt = $this->model->read();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($results);
    }

    public function readSingle($id) {
        $this->model->MaLoai = $id;
        $this->model->readSingle();
        if ($this->model->TenLoai) {
            $item = [
                "MaLoai" => $this->model->MaLoai,
                "TenLoai" => $this->model->TenLoai,
                "MoTa" => $this->model->MoTa
            ];
            return json_encode($item);
        } else {
            return json_encode(["message" => "Record not found."]);
        }
    }

    public function update($data) {
        $this->model->MaLoai = $data['MaLoai'];
        $this->model->TenLoai = $data['TenLoai'];
        $this->model->MoTa = $data['MoTa'];
        if ($this->model->update()) {
            return json_encode(["message" => "Record updated successfully."]);
        } else {
            return json_encode(["message" => "Failed to update record."]);
        }
    }

    public function delete($id) {
        $this->model->MaLoai = $id;
        if ($this->model->delete()) {
            return json_encode(["message" => "Record deleted successfully."]);
        } else {
            return json_encode(["message" => "Failed to delete record."]);
        }
    }
}
?>
