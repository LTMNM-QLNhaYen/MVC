<?php
include("../model/DB.php");


$conn = new DB();

$sql_hsx = "SELECT MaHSX, TenHSX FROM hangsanxuat";
$stmt_hsx = $conn->prepare($sql_hsx);
$stmt_hsx->execute();
$result_hsx = $stmt_hsx->fetchAll(PDO::FETCH_ASSOC);

$sql_sp_all = "SELECT s.MaSP, s.TenSP, s.DonViTinh, c.MaHSX, h.TenHSX
               FROM sanpham s
               INNER JOIN chitiet_sanpham_hangsanxuat c ON s.MaSP = c.MaSP
               INNER JOIN hangsanxuat h ON c.MaHSX = h.MaHSX";
$stmt_sp_all = $conn->prepare($sql_sp_all);
$stmt_sp_all->execute();
$result_sp_all = $stmt_sp_all->fetchAll(PDO::FETCH_ASSOC);

$products_by_manufacturer = [];
foreach ($result_sp_all as $product) {
    $manufacturer_id = $product['MaHSX'];
    if (!isset($products_by_manufacturer[$manufacturer_id])) {
        $products_by_manufacturer[$manufacturer_id] = [];
    }
    $products_by_manufacturer[$manufacturer_id][] = $product;
}


if (isset($_POST['btn_them'])) {
  // Kiểm tra xem dữ liệu từ form có tồn tại không
  if (isset($_POST['btn_hsx']) && isset($_POST['txt_masp']) && isset($_POST['txt_soluong'])) {
      // Lấy thông tin từ form
      $hxs = $_POST['btn_hsx'];
      $date = date("Y-m-d");

      // Thêm phiếu đặt vào cơ sở dữ liệu
      $sql_insert_phieudat = "INSERT INTO phieudat (NgayLap, TrangThai, MaHSX) VALUES (?, 'Chưa hoàn thành', ?)";
      $stmt_insert_phieudat = $conn->prepare($sql_insert_phieudat);
      $stmt_insert_phieudat->execute([$date, $hxs]);

      // Lấy ID của phiếu đặt vừa được thêm vào
      $lastInsertedId = $conn->getConnection()->lastInsertId();

      // Thêm chi tiết phiếu đặt (sản phẩm và số lượng) vào cơ sở dữ liệu
      foreach ($_POST['txt_masp'] as $index => $maSP) {
          $quantity = $_POST['txt_soluong'][$index];
          if (!empty($quantity)) {
              $sql_insert_chitiet = "INSERT INTO chitietphieudat (MaPhieuDat, MaSanPham, SoLuong) VALUES (?, ?, ?)";
              $stmt_insert_chitiet = $conn->prepare($sql_insert_chitiet);
              $stmt_insert_chitiet->execute([$lastInsertedId, $maSP, $quantity]);
          }
      }
  } else {
      // Xử lý khi không có dữ liệu gửi từ form
      echo "Dữ liệu từ form không tồn tại!";
  }
}


?>



<!doctype html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
  <head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <title>Quản lý thông tin khách hàng</title>
    <link rel="stylesheet" type="text/css" href="style.css">
<style>


</style>

  </head>
  <body>
    
      <div class="row">
        <div class="col-md-8"></div>
        <div class="col-6 col-md-4"></div>
      </div>

      <div class="row">
        <div id="menu"></div>
      </div>
      <div class="container">
      <div class="row shadow-lg p- mb-5 bg-body-tertiary rou3nded">
        <div class="col-2">
          <div id="sidebar"></div>
        </div>
      
        <div class="col-10" style="padding: 20px 20px 20px 10px;">


          
  <div class="container mt-5">
    <h4>Thêm phiếu đặt hàng</h4>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" name="add_PD">
        <div style="margin: 10px 10px 10px 0">
            <?php foreach ($products_by_manufacturer as $manufacturer_id => $products) { ?>
              <button type="button" id="btn_hsx_<?php echo $manufacturer_id; ?>" class="btn btn-outline-info manufacturerButton" value="<?php echo $manufacturer_id; ?>" data-bs-toggle="modal" data-bs-target="#productModal_<?php echo $manufacturer_id; ?>">
    <?php echo $products[0]['TenHSX']; ?>
</button>


            <?php } ?>
        </div>
       

        <!-- Product Modals -->
        <?php foreach ($products_by_manufacturer as $manufacturer_id => $products) { ?>
          <div class="modal fade custom-modal-width" id="productModal_<?php echo $manufacturer_id; ?>" tabindex="-1" aria-labelledby="productModalLabel_<?php echo $manufacturer_id; ?>" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" >
                    <div class="modal-content">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" name="add_PD">

                        <div class="modal-header" >
                            <h5 class="modal-title" id="productModalLabel_<?php echo $manufacturer_id; ?>"><?php echo $products[0]['TenHSX']; ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <input type="hidden" name="btn_hsx" value="<?php echo $manufacturer_id; ?>">

                            <div class="row row-cols-4" id="productList_<?php echo $manufacturer_id; ?>">
                                <?php foreach ($products as $product) { ?>
                                    <div class="card" style="width: 15rem; margin: 5px;" >
                                        <div class="card-body">
                                        
                                            <h5 class="card-title" ><?php echo $product['TenSP']; ?></h5>
                                            <p class="card-text">Đơn vị tính : <span style="color: red;"><?php echo $product['DonViTinh']; ?></span></p>
                                            <input type="hidden" name="txt_masp[]" value="<?php echo $product['MaSP']; ?>">
                                            <input class="form-control" type="number" name="txt_soluong[]" placeholder="Số lượng đặt" >
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                            <button type="submit" class="btn btn-primary" name="btn_them">Lập phiếu đặt</button>
                        </div>
                    </div>
                    </form>

                </div>
            </div>
        <?php } ?>
    </form>
</div>

          
        </div>
      </div>
      </div>

      <div class="row">
        <div id="footer">
        </div>
      </div>
    </div>

    <script>
      async function loadContent() {
        try {
          const response = await fetch('Menu_QL.php');
          const content = await response.text();
          document.getElementById('menu').innerHTML = content;
        } catch (error) {
          console.error('Error loading content:', error);
        }
      }
      loadContent();

      async function loadSidebar() {
        try {
          const response = await fetch('SideBar_QL.php');
          const content = await response.text();
          document.getElementById('sidebar').innerHTML = content;
        } catch (error) {
          console.error('Error loading sidebar:', error);
        }
      }
      loadSidebar();

      async function loadFooter() {
        try {
          const response = await fetch('Footer.php');
          const content = await response.text();
          document.getElementById('footer').innerHTML = content;
        } catch (error) {
          console.error('Error loading footer:', error);
        }
      }
      loadFooter();
    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
  </body>
</html>
