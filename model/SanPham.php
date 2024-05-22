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
                  SET TenSP=:TenSP, DonViTinh=:DonViTinh, GiaBan=:GiaBan, GiaNhap=:GiaNhap, 
                      TinhTrang=:TinhTrang, MoTa=:MoTa, ThongTin=:ThongTin, 
                      ImageUrl=:ImageUrl, MaLoai=:MaLoai, TonKho=:TonKho";
        $stmt = $this->conn->prepare($query);

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

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET TenSP=:TenSP, DonViTinh=:DonViTinh, GiaBan=:GiaBan, GiaNhap=:GiaNhap, 
                      TinhTrang=:TinhTrang, MoTa=:MoTa, ThongTin=:ThongTin, 
                      ImageUrl=:ImageUrl, MaLoai=:MaLoai, TonKho=:TonKho
                  WHERE MaSP = :MaSP";
    
        $stmt = $this->conn->prepare($query);
    
        // Clean data
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
        $this->MaSP = htmlspecialchars(strip_tags($this->MaSP));
    
        // Bind data
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
        $stmt->bindParam(':MaSP', $this->MaSP);
    
        // Execute query
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
    
          
              public function delete() {
                  $query = "DELETE FROM " . $this->table . " WHERE MaSP = :MaSP";
                  $stmt = $this->conn->prepare($query);
                  $stmt->bindParam(':MaSP', $this->MaSP);
          
                  try {
                      return $stmt->execute();
                  } catch (PDOException $e) {
                      return false;
                  }
              }
          
              public function findByName($name) {
                  $query = "SELECT * FROM " . $this->table . " WHERE TenSP LIKE :name";
                  $stmt = $this->conn->prepare($query);
                  $name = "%$name%";
                  $stmt->bindParam(':name', $name);
                  $stmt->execute();
                  return $stmt->fetchAll(PDO::FETCH_ASSOC);
              }
          
              public function sortBy($column, $order) {
                  $query = "SELECT * FROM " . $this->table . " ORDER BY $column $order";
                  $stmt = $this->conn->prepare($query);
                  $stmt->execute();
                  return $stmt->fetchAll(PDO::FETCH_ASSOC);
              }
          
              public function getAll() {
                  $query = "SELECT * FROM " . $this->table;
                  $stmt = $this->conn->prepare($query);
                  $stmt->execute();
                  return $stmt->fetchAll(PDO::FETCH_ASSOC);
              }
          
              public function getByManufacturer($manufacturerId) {
                  $query = "SELECT * FROM " . $this->table . " WHERE MaLoai = :manufacturerId";
                  $stmt = $this->conn->prepare($query);
                  $stmt->bindParam(':manufacturerId', $manufacturerId);
                  $stmt->execute();
                  return $stmt->fetchAll(PDO::FETCH_ASSOC);
              }
          }
          ?>
          
