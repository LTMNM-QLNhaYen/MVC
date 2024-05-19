<?php
require_once("DB.php");

class TaiKhoanNV {
    private $conn;
    private $table = "TaiKhoanNV";

    public $UserName;
    public $MatKhau;
    public $MaNV;
    public $MaQuyen;
    public $TrangThai;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . "
            SET
                UserName = :UserName,
                MatKhau = :MatKhau,
                MaNV = :MaNV,
                maquyen = :MaQuyen,
                TrangThai = :TrangThai";

        $stmt = $this->conn->prepare($query);

        $this->UserName = htmlspecialchars(strip_tags($this->UserName));
        $this->MatKhau = htmlspecialchars(strip_tags($this->MatKhau));
        $this->MaNV = htmlspecialchars(strip_tags($this->MaNV));
        $this->MaQuyen = htmlspecialchars(strip_tags($this->MaQuyen));
        $this->TrangThai = htmlspecialchars(strip_tags($this->TrangThai));

        $stmt->bindParam(':UserName', $this->UserName);
        $stmt->bindParam(':MatKhau', $this->MatKhau);
        $stmt->bindParam(':MaNV', $this->MaNV);
        $stmt->bindParam(':MaQuyen', $this->MaQuyen);
        $stmt->bindParam(':TrangThai', $this->TrangThai);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table;

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function update() {
        $query = "UPDATE " . $this->table . "
            SET
                MatKhau = :MatKhau,
                MaNV = :MaNV,
                maquyen = :MaQuyen,
                TrangThai = :TrangThai
            WHERE
                UserName = :UserName";

        $stmt = $this->conn->prepare($query);

        $this->UserName = htmlspecialchars(strip_tags($this->UserName));
        $this->MatKhau = htmlspecialchars(strip_tags($this->MatKhau));
        $this->MaNV = htmlspecialchars(strip_tags($this->MaNV));
        $this->MaQuyen = htmlspecialchars(strip_tags($this->MaQuyen));
        $this->TrangThai = htmlspecialchars(strip_tags($this->TrangThai));

        $stmt->bindParam(':UserName', $this->UserName);
        $stmt->bindParam(':MatKhau', $this->MatKhau);
        $stmt->bindParam(':MaNV', $this->MaNV);
        $stmt->bindParam(':MaQuyen', $this->MaQuyen);
        $stmt->bindParam(':TrangThai', $this->TrangThai);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE UserName = :UserName";

        $stmt = $this->conn->prepare($query);

        $this->UserName = htmlspecialchars(strip_tags($this->UserName));

        $stmt->bindParam(':UserName', $this->UserName);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);

        return false;
    }
}
?>
