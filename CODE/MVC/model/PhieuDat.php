<?php
require_once("DB.php");

class PhieuDat {
    private $conn;
    private $table = "PhieuDat";

    public $MaPhieuDat;
    public $NgayLap;
    public $TrangThai;
    public $MaHSX;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " SET NgayLap=:NgayLap, TrangThai=:TrangThai, MaHSX=:MaHSX";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':NgayLap', $this->NgayLap);
        $stmt->bindParam(':TrangThai', $this->TrangThai);
        $stmt->bindParam(':MaHSX', $this->MaHSX);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            // Handle the exception, log error, or return false
            return false;
        }
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
