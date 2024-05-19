<?php
require_once 'model/SanPham.php';

class SanPhamController {
    private $model;

    public function __construct($db) {
        $this->model = new SanPham($db);
    }

    public function create($data) {
        $this->model->TenSP = $data['TenSP'];
        $this->model->DonViTinh = $data['DonViTinh'];
        $this->model->GiaBan = $data['GiaBan'];
        $this->model->GiaNhap = $data['GiaNhap'];
        $this->model->TinhTrang = $data['TinhTrang'];
        $this->model->MoTa = $data['MoTa'];
        $this->model->ThongTin = $data['ThongTin'];
        $this->model->ImageUrl = $data['ImageUrl'];
        $this->model->MaLoai = $data['MaLoai'];
        $this->model->TonKho = $data['TonKho'];

        if ($this->model->create()) {
            return true;
        }

        return false;
    }

    public function read() {
        return $this->model->read();
    }

    public function update($data) {
        $this->model->MaSP = $data['MaSP'];
        $this->model->TenSP = $data['TenSP'];
        $this->model->DonViTinh = $data['DonViTinh'];
        $this->model->GiaBan = $data['GiaBan'];
        $this->model->GiaNhap = $data['GiaNhap'];
        $this->model->TinhTrang = $data['TinhTrang'];
        $this->model->MoTa = $data['MoTa'];
        $this->model->ThongTin = $data['ThongTin'];
        $this->model->ImageUrl = $data['ImageUrl'];
        $this->model->MaLoai = $data['MaLoai'];
        $this->model->TonKho = $data['TonKho'];

        if ($this->model->update()) {
            return true;
        }

        return false;
    }

    public function delete($id) {
        $this->model->MaSP = $id;

        if ($this->model->delete()) {
            return true;
        }

        return false;
    }
}
?>
