<?php
require_once("DB.php");

class TaiKhoanNV {
    private $conn;
    private $table = "TaiKhoanNV";

    public $UserName;
    public $MatKhau;
    public $MaNV;
    public $maquyen;
    public $TrangThai;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " SET UserName=:UserName, MatKhau=:MatKhau, MaNV=:MaNV, maquyen=:maquyen, TrangThai=:TrangThai";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(':UserName', $this->UserName);
        $stmt->bindParam(':MatKhau', $this->MatKhau);
        $stmt->bindParam(':MaNV', $this->MaNV);
        $stmt->bindParam(':maquyen', $this->maquyen);
        $stmt->bindParam(':TrangThai', $this->TrangThai);
      
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            // Handle the exception, log error, or return false
            return false;
        }
    }

    public function read() {
        $sql = "SELECT UserName, MatKhau, MaNV, maquyen, TrangThai FROM TaiKhoanNV";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readSingle() {
        $query = "SELECT * FROM " . $this->table . " WHERE UserName = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->UserName);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->UserName = $row['UserName'];
            $this->MatKhau = $row['MatKhau'];
            $this->MaNV = $row['MaNV'];
            $this->maquyen = $row['maquyen'];
            $this->TrangThai = $row['TrangThai'];
        }
    }

    public function update() {
        $query = "UPDATE " . $this->table . " SET MatKhau = :MatKhau, MaNV = :MaNV, maquyen = :maquyen, TrangThai = :TrangThai WHERE UserName = :UserName";
        $stmt = $this->conn->prepare($query);

        $this->MatKhau = htmlspecialchars(strip_tags($this->MatKhau));
        $this->MaNV = htmlspecialchars(strip_tags($this->MaNV));
        $this->maquyen = htmlspecialchars(strip_tags($this->maquyen));
        $this->TrangThai = htmlspecialchars(strip_tags($this->TrangThai));
        $this->UserName = htmlspecialchars(strip_tags($this->UserName));

        $stmt->bindParam(":MatKhau", $this->MatKhau);
        $stmt->bindParam(":MaNV", $this->MaNV);
        $stmt->bindParam(":maquyen", $this->maquyen);
        $stmt->bindParam(":TrangThai", $this->TrangThai);
        $stmt->bindParam(":UserName", $this->UserName);

        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE UserName = :UserName";
        $stmt = $this->conn->prepare($query);

        $this->UserName = htmlspecialchars(strip_tags($this->UserName));
        $stmt->bindParam(":UserName", $this->UserName);

        return $stmt->execute();
    }
    public function checkLogin($UserName, $MatKhau) {
        $query = "SELECT * FROM {$this->table} WHERE UserName = :UserName AND MatKhau = :MatKhau";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':UserName', $UserName);
        $stmt->bindParam(':MatKhau', $MatKhau);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function getAccountByUsername($username) {
        $query = "SELECT * FROM TaiKhoanNV WHERE Username = ?";
        $stmt = $this->conn->prepare($query); // Thay đổi từ $this->db thành $this->conn
        $stmt->bindParam(1, $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
}
?>
