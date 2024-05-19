<?php

require_once("DB.php");

class LoaiSanPham {
    private $conn;
    private $table = "LoaiSanPham";

    public $MaLoai;
    public $TenLoai;
    public $MoTa;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " SET TenLoai=:TenLoai, MoTa=:MoTa";
        $stmt = $this->conn->prepare($query);

        $this->TenLoai = htmlspecialchars(strip_tags($this->TenLoai));
        $this->MoTa = htmlspecialchars(strip_tags($this->MoTa));

        $stmt->bindParam(":TenLoai", $this->TenLoai);
        $stmt->bindParam(":MoTa", $this->MoTa);

        return $stmt->execute();
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readSingle() {
        $query = "SELECT * FROM " . $this->table . " WHERE MaLoai = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->MaLoai);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->TenLoai = $row['TenLoai'];
            $this->MoTa = $row['MoTa'];
        }
    }

    public function update() {
        $query = "UPDATE " . $this->table . " SET TenLoai = :TenLoai, MoTa = :MoTa WHERE MaLoai = :MaLoai";
        $stmt = $this->conn->prepare($query);

        $this->TenLoai = htmlspecialchars(strip_tags($this->TenLoai));
        $this->MoTa = htmlspecialchars(strip_tags($this->MoTa));
        $this->MaLoai = htmlspecialchars(strip_tags($this->MaLoai));

        $stmt->bindParam(":TenLoai", $this->TenLoai);
        $stmt->bindParam(":MoTa", $this->MoTa);
        $stmt->bindParam(":MaLoai", $this->MaLoai);

        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE MaLoai = :MaLoai";
        $stmt = $this->conn->prepare($query);

        $this->MaLoai = htmlspecialchars(strip_tags($this->MaLoai));
        $stmt->bindParam(":MaLoai", $this->MaLoai);

        return $stmt->execute();
    }
}
?>
