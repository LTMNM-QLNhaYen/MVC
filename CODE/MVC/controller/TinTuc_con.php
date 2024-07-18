<?php
require_once '../model/TinTuc.php';

class TinTucController {
    private $model;

    public function __construct($db) {
        $this->model = new TinTuc($db);
    }

    public function create($data) {
        $this->model->Title = $data['Title'];
        $this->model->NoiDung = $data['NoiDung'];
        $this->model->NgayDang = $data['NgayDang'];
        return $this->model->create();
    }

    public function read() {
        return $this->model->read();
    }

    public function searchByTitle($title) {
        return $this->model->searchByTitle($title);
    }

    public function getAllAscending() {
        return $this->model->getAllAscending();
    }

    public function getAllDescending() {
        return $this->model->getAllDescending();
    }

    public function readSingle($id) {
        $this->model->MaTin = $id;
        $this->model->readSingle();
        if ($this->model->Title) {
            $item = [
                "MaTin" => $this->model->MaTin,
                "Title" => $this->model->Title,
                "NoiDung" => $this->model->NoiDung,
                "NgayDang" => $this->model->NgayDang
            ];
            return json_encode($item);
        } else {
            return json_encode(["message" => "Record not found."]);
        }
    }

    public function update($data) {
        $this->model->MaTin = $data['MaTin'];
        $this->model->Title = $data['Title'];
        $this->model->NoiDung = $data['NoiDung'];
        $this->model->NgayDang = $data['NgayDang'];

        if ($this->model->update()) {
            return json_encode(["message" => "Record updated successfully."]);
        } else {
            return json_encode(["message" => "Failed to update record."]);
        }
    }

    public function delete($id) {
        $this->model->MaTin = $id;
        if ($this->model->delete()) {
            return json_encode(["message" => "Record deleted successfully."]);
        } else {
            return json_encode(["message" => "Failed to delete record."]);
        }
    }
}
?>
