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

    public function count() {
        $query = "SELECT COUNT(*) AS total FROM SanPham";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }
    
    // Phương thức để đọc sản phẩm cho mỗi trang
    public function readPerPage($start, $limit) {
        $query = "SELECT * FROM SanPham LIMIT :start, :limit";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        $sanPham = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $sanPham;
    } 
    public function getSanPhamById($MaSP) {
        $query = "SELECT * FROM SanPham WHERE MaSP = :MaSP";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':MaSP', $MaSP, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // In SanPhamController.php

        public function findByCategory($category, $start, $limit) {
            $query = "SELECT * FROM SanPham WHERE MaLoai = :category LIMIT :start, :limit";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":category", $category, PDO::PARAM_STR);
            $stmt->bindParam(":start", $start, PDO::PARAM_INT);
            $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }


        public function countByCategory($category) {
            // Viết câu truy vấn SQL để đếm số lượng sản phẩm theo loại sản phẩm
            $query = "SELECT COUNT(*) AS total FROM SanPham WHERE MaLoai = :category";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":category", $category, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        }
        // In SanPhamController.php

   // In SanPhamController.php

public function getRandomProductsByCategory($category, $limit) {
    // Prepare the SQL query to fetch random products from the same category
    $query = "SELECT * FROM SanPham WHERE MaLoai = :category ORDER BY RAND() LIMIT :limit";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(":category", $category, PDO::PARAM_INT);
    $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $products;
}


        
    
}
?>
