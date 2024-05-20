<?php
class TinTuc {
    private $db;
    public $MaTin;
    public $Title;
    public $NoiDung;
    public $NgayDang;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create() {
        $sql = "INSERT INTO TinTuc (Title,  NoiDung, NgayDang) VALUES (:Title,  :NoiDung, :NgayDang)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':Title', $this->Title);
        $stmt->bindParam(':NoiDung', $this->NoiDung);
        $stmt->bindParam(':NgayDang', $this->NgayDang);

        return $stmt->execute();
    }

    public function read() {
        $sql = "SELECT * FROM TinTuc";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readSingle() {
        $sql = "SELECT * FROM TinTuc WHERE MaTin = :MaTin";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':MaTin', $this->MaTin);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->Title = $row['Title'];
            $this->NoiDung = $row['NoiDung'];
            $this->NgayDang = $row['NgayDang'];
        }
    }

    public function update() {
        $sql = "UPDATE TinTuc SET Title = :Title, NoiDung = :NoiDung, NgayDang = :NgayDang WHERE MaTin = :MaTin";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':MaTin', $this->MaTin);
        $stmt->bindParam(':Title', $this->Title);
        $stmt->bindParam(':NoiDung', $this->NoiDung);
        $stmt->bindParam(':NgayDang', $this->NgayDang);

        return $stmt->execute();
    }

    public function delete() {
        $sql = "DELETE FROM TinTuc WHERE MaTin = :MaTin";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':MaTin', $this->MaTin);

        return $stmt->execute();
    }

    public function searchByTitle($title) {
        $sql = "SELECT * FROM TinTuc WHERE Title LIKE :title";
        $stmt = $this->db->prepare($sql);
        $title = "%$title%";
        $stmt->bindParam(':title', $title);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllAscending() {
        $sql = "SELECT * FROM TinTuc ORDER BY NgayDang ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllDescending() {
        $sql = "SELECT * FROM TinTuc ORDER BY NgayDang DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
