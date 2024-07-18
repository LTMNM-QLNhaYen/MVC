<?php
require '../model/DB.php'; // Tệp kết nối cơ sở dữ liệu
$hsxId = $_GET['hsx_id'];
$query = $conn->prepare("SELECT MaSP as id, TenSP as name FROM SanPham WHERE MaHSX = ?");
$query->execute([$hsxId]);
echo json_encode($query->fetchAll(PDO::FETCH_ASSOC));
?>
