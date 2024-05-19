<?php
require_once("DB.php");

class PhanQuyen {
    private $conn;
    private $table = "PhanQuyen";

    public $MaQuyen;
    public $TenQuyen;
    public $TrangThai;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . "
            SET
                maquyen = :MaQuyen,
                tenquyen = :TenQuyen,
                trangthai = :TrangThai";

        $stmt = $this->conn->prepare($query);

        $this->MaQuyen = htmlspecialchars(strip_tags($this->MaQuyen));
        $this->TenQuyen = htmlspecialchars(strip_tags($this->TenQuyen));
        $this->TrangThai = htmlspecialchars(strip_tags($this->TrangThai));

        $stmt->bindParam(':MaQuyen', $this->MaQuyen);
        $stmt->bindParam(':TenQuyen', $this->TenQuyen);
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
                tenquyen = :TenQuyen,
                trangthai = :TrangThai
            WHERE
                maquyen = :MaQuyen";

        $stmt = $this->conn->prepare($query);

        $this->MaQuyen = htmlspecialchars(strip_tags($this->MaQuyen));
        $this->TenQuyen = htmlspecialchars(strip_tags($this->TenQuyen));
        $this->TrangThai = htmlspecialchars(strip_tags($this->TrangThai));

        $stmt->bindParam(':MaQuyen', $this->MaQuyen);
        $stmt->bindParam(':TenQuyen', $this->TenQuyen);
        $stmt->bindParam(':TrangThai', $this->TrangThai);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE maquyen = :MaQuyen";

        $stmt = $this->conn->prepare($query);

        $this->MaQuyen = htmlspecialchars(strip_tags($this->MaQuyen));

        $stmt->bindParam(':MaQuyen', $this->MaQuyen);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);

        return false;
    }
}
?>
