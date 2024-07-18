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
    
    public function create($data) {
        $taiKhoanNV = new TaiKhoanNV($this->db);
    
        $taiKhoanNV->UserName = $data['UserName'];
        $taiKhoanNV->MatKhau = $data['MatKhau'];
        $taiKhoanNV->MaNV = $data['MaNV'];
        $taiKhoanNV->maquyen = $data['maquyen'];
        $taiKhoanNV->TrangThai = $data['TrangThai'];
    
        return $taiKhoanNV->create();
    }
    
    public function read() {
        $taiKhoanNV = new TaiKhoanNV($this->db);
        return $taiKhoanNV->read();
    }

    public function update($data) {
        $taiKhoanNV = new TaiKhoanNV($this->db);
    
        $taiKhoanNV->UserName = $data['UserName'];
        $taiKhoanNV->MatKhau = $data['MatKhau'];
        $taiKhoanNV->MaNV = $data['MaNV'];
        $taiKhoanNV->maquyen = $data['maquyen'];
        $taiKhoanNV->TrangThai = $data['TrangThai'];
    
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
    public function searchByUserName($UserName) {
        return $this->taiKhoanModel->searchByUserName($UserName);
    }

    public function getAllAscending() {
        return $this->taiKhoanModel->getAllAscending();
    }

    public function getAllDescending() {
        return $this->taiKhoanModel->getAllDescending();
    }
    public function getEmployeesWithoutAccount() {
        // Gọi phương thức tương ứng từ model TaiKhoanNV
        return $this->taiKhoanModel->getEmployeesWithoutAccount();
    } 

    public function update1($data) {
        return $this->taiKhoanModel->update($data);
    }

    public function getByUserName1($UserName) {
        return $this->taiKhoanModel->getByUserName1($UserName);
    }

    
}
?>
