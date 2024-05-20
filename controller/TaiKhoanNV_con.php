<?php
require_once("../model/DB.php");
require_once("../model/TaiKhoanNV.php");

class TaiKhoanNVController {
    private $db;
    private $table_name = "TaiKhoanNV";

    private $taiKhoanModel;

    public function __construct($db) {
        $this->db = $db;
        $this->taiKhoanModel = new TaiKhoanNV($db);
    }

    public function getAccountInfo($username) {
        $accountInfo = $this->taiKhoanModel->getAccountByUsername($username);
        return $accountInfo;
    }
    
    public function create($UserName, $MatKhau, $MaNV, $MaQuyen, $TrangThai) {
        $taiKhoanNV = new TaiKhoanNV($this->db);

        $taiKhoanNV->UserName = $UserName;
        $taiKhoanNV->MatKhau = $MatKhau;
        $taiKhoanNV->MaNV = $MaNV;
        $taiKhoanNV->MaQuyen = $MaQuyen;
        $taiKhoanNV->TrangThai = $TrangThai;

        return $taiKhoanNV->create();
    }

    public function read() {
        $taiKhoanNV = new TaiKhoanNV($this->db);
        return $taiKhoanNV->read();
    }

    public function update($UserName, $MatKhau, $MaNV, $MaQuyen, $TrangThai) {
        $taiKhoanNV = new TaiKhoanNV($this->db);

        $taiKhoanNV->UserName = $UserName;
        $taiKhoanNV->MatKhau = $MatKhau;
        $taiKhoanNV->MaNV = $MaNV;
        $taiKhoanNV->MaQuyen = $MaQuyen;
        $taiKhoanNV->TrangThai = $TrangThai;

        return $taiKhoanNV->update();
    }

    public function delete($UserName) {
        $taiKhoanNV = new TaiKhoanNV($this->db);
        $taiKhoanNV->UserName = $UserName;
        return $taiKhoanNV->delete();
    }
    public function Checklogin($UserName, $MatKhau) {
        $taiKhoanNV = new TaiKhoanNV($this->db);
        $result = $taiKhoanNV->checkLogin($UserName, $MatKhau);
        if ($result) {
            // Tài khoản hợp lệ, trả về thông tin của người dùng
            return $result;
        } else {
            // Tài khoản không hợp lệ
            return false;
        }
    }
 
    
}
?>
