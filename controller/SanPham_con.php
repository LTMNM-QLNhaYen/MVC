<?php
require_once("../model/SanPham.php");

class SanPhamController {
    private $db;
    private $sanPhamModel;

    public function __construct($db) {
        $this->db = $db;
        $this->sanPhamModel = new SanPham($db);
    }

   
    public function create($data) {
        return $this->sanPhamModel->create($data);
    }

    public function read() {
        return $this->sanPhamModel->read();
    }

    public function update($data) {
        return $this->sanPhamModel->update($data);
    }

    public function delete($MaSP) {
        return $this->sanPhamModel->delete($MaSP);
    }

    public function searchByName($name) {
        return $this->sanPhamModel->searchByName($name);
    }

    public function getAllAscending() {
        return $this->sanPhamModel->getAllAscending();
    }

    public function getAllDescending() {
        return $this->sanPhamModel->getAllDescending();
    }

    public function findByName($name) {
        return $this->sanPhamModel->findByName($name);
    }

    public function sortBy($column, $order) {
        return $this->sanPhamModel->sortBy($column, $order);
    }

    public function getAll() {
        return $this->sanPhamModel->getAll();
    }

    public function getByManufacturer($manufacturerId) {
        return $this->sanPhamModel->getByManufacturer($manufacturerId);
    }
}
?>
