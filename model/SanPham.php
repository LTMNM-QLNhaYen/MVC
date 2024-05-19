<?php
require_once("DB.php");

class SanPham {
    private $conn;
    private $table = "SanPham";

    public $MaSP;
    public $TenSP;
    public $DonViTinh;
    public $GiaBan;
    public $GiaNhap;
    public $TinhTrang;
    public $MoTa;
    public $ThongTin;
    public $ImageUrl;
    public $MaLoai;
    public $TonKho;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . "
            SET
                TenSP = :TenSP,
                DonViTinh = :DonViTinh,
                GiaBan = :GiaBan,
                GiaNhap = :GiaNhap,
                TinhTrang = :TinhTrang,
                MoTa = :MoTa,
                ThongTin = :ThongTin,
                ImageUrl = :ImageUrl,
                MaLoai = :MaLoai,
                TonKho = :TonKho";

        $stmt = $this->conn->prepare($query);

        $this->TenSP = htmlspecialchars(strip_tags($this->TenSP));
        $this->DonViTinh = htmlspecialchars(strip_tags($this->DonViTinh));
        $this->GiaBan = htmlspecialchars(strip_tags($this->GiaBan));
        $this->GiaNhap = htmlspecialchars(strip_tags($this->GiaNhap));
        $this->TinhTrang = htmlspecialchars(strip_tags($this->TinhTrang));
        $this->MoTa = htmlspecialchars(strip_tags($this->MoTa));
        $this->ThongTin = htmlspecialchars(strip_tags($this->ThongTin));
        $this->ImageUrl = htmlspecialchars(strip_tags($this->ImageUrl));
        $this->MaLoai = htmlspecialchars(strip_tags($this->MaLoai));
        $this->TonKho = htmlspecialchars(strip_tags($this->TonKho));

        $stmt->bindParam(':TenSP', $this->TenSP);
        $stmt->bindParam(':DonViTinh', $this->DonViTinh);
        $stmt->bindParam(':GiaBan', $this->GiaBan);
        $stmt->bindParam(':GiaNhap', $this->GiaNhap);
        $stmt->bindParam(':TinhTrang', $this->TinhTrang);
        $stmt->bindParam(':MoTa', $this->MoTa);
        $stmt->bindParam(':ThongTin', $this->ThongTin);
        $stmt->bindParam(':ImageUrl', $this->ImageUrl);
        $stmt->bindParam(':MaLoai', $this->MaLoai);
        $stmt->bindParam(':TonKho', $this->TonKho);

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
                TenSP = :TenSP,
                DonViTinh = :DonViTinh,
                GiaBan = :GiaBan,
                GiaNhap = :GiaNhap,
                TinhTrang = :TinhTrang,
                MoTa = :MoTa,
                ThongTin = :ThongTin,
                ImageUrl = :ImageUrl,
                MaLoai = :MaLoai,
                TonKho = :TonKho
            WHERE
                MaSP = :MaSP";

        $stmt = $this->conn->prepare($query);

        $this->MaSP = htmlspecialchars(strip_tags($this->MaSP));
        $this->TenSP = htmlspecialchars(strip_tags($this->TenSP));
        $this->DonViTinh = htmlspecialchars(strip_tags($this->DonViTinh));
        $this->GiaBan = htmlspecialchars(strip_tags($this->GiaBan));
        $this->GiaNhap = htmlspecialchars(strip_tags($this->GiaNhap));
        $this->TinhTrang = htmlspecialchars(strip_tags($this->TinhTrang));
        $this->MoTa = htmlspecialchars(strip_tags($this->MoTa));
        $this->ThongTin = htmlspecialchars(strip_tags($this->ThongTin));
        $this->ImageUrl = htmlspecialchars(strip_tags($this->ImageUrl));
        $this->MaLoai = htmlspecialchars(strip_tags($this->MaLoai));
        $this->TonKho = htmlspecialchars(strip_tags($this->TonKho));

        $stmt->bindParam(':MaSP', $this->MaSP);
        $stmt->bindParam(':TenSP', $this->TenSP);
        $stmt->bindParam(':DonViTinh', $this->DonViTinh);
        $stmt->bindParam(':GiaBan', $this->GiaBan);
        $stmt->bindParam(':GiaNhap', $this->GiaNhap);
        $stmt->bindParam(':TinhTrang', $this->TinhTrang);
        $stmt->bindParam(':MoTa', $this->MoTa);
        $stmt->bindParam(':ThongTin', $this->ThongTin);
        $stmt->bindParam(':ImageUrl', $this->ImageUrl);
        $stmt->bindParam(':MaLoai', $this->MaLoai);
        $stmt->bindParam(':TonKho', $this->TonKho);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE MaSP = :MaSP";

        $stmt= $this->conn->prepare($query);

        $this->MaSP = htmlspecialchars(strip_tags($this->MaSP));

        $stmt->bindParam(':MaSP', $this->MaSP);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);

        return false;
    }
}
?>

