<?php
require_once '../model/NhanVien.php';

class NhanVienController {
    private $model;

    public function __construct($db) {
        $this->model = new NhanVien($db);
    }

    public function create($data) {
        $this->model->TenNV = $data['TenNV'];
        $this->model->Phai = $data['Phai'];
        $this->model->NgaySinh = $data['NgaySinh'];
        $this->model->DiaChi = $data['DiaChi'];
        $this->model->SDT = $data['SDT'];
        return $this->model->create();
    }

    public function read() {
        return $this->model->read();
    }
    public function getByGender($gender) {
        // Use $this->nhanvien instead of $this->model
        return $this->model->getByGender($gender);
    }

    public function getAllAscending() {
        // Use $this->nhanvien instead of $this->model
        return $this->model->getAllAscending();
    }

    public function getAllDescending() {
        // Use $this->nhanvien instead of $this->model
        return $this->model->getAllDescending();
    }

    public function searchByName($name) {
        return $this->model->searchByName($name);
    }


public function getEmployeeById($employeeId) {
    // Implement code to fetch employee information from the database based on $employeeId
    // For example:
    $employee = $this->db->getEmployeeById($employeeId); // Assuming DB class has a method to fetch an employee by ID
    return $employee; // Return the employee data (an associative array) if found, or false otherwise
}


    public function readSingle($id) {
        $this->model->MaNV = $id;
        $this->model->readSingle();
        if ($this->model->TenNV) {
            $item = [
                "MaNV" => $this->model->MaNV,
                "TenNV" => $this->model->TenNV,
                "Phai" => $this->model->Phai,
                "NgaySinh" => $this->model->NgaySinh,
                "DiaChi" => $this->model->DiaChi,
                "SDT" => $this->model->SDT,
                "TrangThai" => $this->model->TrangThai
            ];
            return json_encode($item);
        } else {
            return json_encode(["message" => "Record not found."]);
        }
    }

    public function update($data) {
        $this->model->MaNV = $data['MaNV'];
        $this->model->TenNV = $data['TenNV'];
        $this->model->Phai = $data['Phai'];
        $this->model->NgaySinh = $data['NgaySinh'];
        $this->model->DiaChi = $data['DiaChi'];
        $this->model->SDT = $data['SDT'];
        $this->model->TrangThai = $data['TrangThai'];

        if ($this->model->update()) {
            return json_encode(["message" => "Record updated successfully."]);
        } else {
            return json_encode(["message" => "Failed to update record."]);
        }
    }

    public function delete($id) {
        $this->model->MaNV = $id;
        if ($this->model->delete()) {
            return json_encode(["message" => "Record deleted successfully."]);
        } else {
            return json_encode(["message" => "Failed to delete record."]);
        }
    }
    
}
?>
