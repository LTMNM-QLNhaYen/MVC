<?php
require_once("DB.php");

class HangSanXuat {
    private $conn;
    private $table = "HangSanXuat";

    public $MaHSX;
    public $TenHSX;
    public $DiaChi;
    public $SDT;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . "
            SET
                TenHSX = :TenHSX,
                DiaChi = :DiaChi,
                SDT = :SDT";

        $stmt = $this->conn->prepare($query);

        $this->TenHSX = htmlspecialchars(strip_tags($this->TenHSX));
        $this->DiaChi = htmlspecialchars(strip_tags($this->DiaChi));
        $this->SDT = htmlspecialchars(strip_tags($this->SDT));

        $stmt->bindParam(':TenHSX', $this->TenHSX);
        $stmt->bindParam(':DiaChi', $this->DiaChi);
        $stmt->bindParam(':SDT', $this->SDT);

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
                TenHSX = :TenHSX,
                DiaChi = :DiaChi,
                SDT = :SDT
            WHERE
                MaHSX = :MaHSX";

        $stmt = $this->conn->prepare($query);

        $this->MaHSX = htmlspecialchars(strip_tags($this->MaHSX));
        $this->TenHSX = htmlspecialchars(strip_tags($this->TenHSX));
        $this->DiaChi = htmlspecialchars(strip_tags($this->DiaChi));
        $this->SDT = htmlspecialchars(strip_tags($this->SDT));

        $stmt->bindParam(':MaHSX', $this->MaHSX);
        $stmt->bindParam(':TenHSX', $this->TenHSX);
        $stmt->bindParam(':DiaChi', $this->DiaChi);
        $stmt->bindParam(':SDT', $this->SDT);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE MaHSX = :MaHSX";

        $stmt = $this->conn->prepare($query);

        $this->MaHSX = htmlspecialchars(strip_tags($this->MaHSX));

        $stmt->bindParam(':MaHSX', $this->MaHSX);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);

        return false;
    }
}
?>
